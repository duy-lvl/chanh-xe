<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Write\Implementations;

use App\Events\OrderCreated;
use App\Exceptions\OrderException;
use App\Models\Order;
use App\Models\TemporaryOrderRoute;
use Carbon\CarbonImmutable;
use Domain\CustomerFacing\Actions\Order\Write\CreateOrderContract;
use Domain\CustomerFacing\DataTransferObjects\Order\DetailedOrderData;
use Domain\CustomerFacing\DataTransferObjects\Order\NewOrderData;
use Domain\CustomerFacing\DataTransferObjects\Order\StationData;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\PriceCalculation\Services\PriceCalculation as PriceCalculationService;
use Domain\Shared\ValueObjects\Distance;
use Illuminate\Support\Facades\DB;

final class CreateOrder implements CreateOrderContract
{
    public function __construct(
        private readonly PriceCalculationService $priceCalculationService,
    ) {
    }

    public function handle(NewOrderData $data): DetailedOrderData
    {
        if ($data->paymentMethod === PaymentMethod::VnPay && $data->collectOnDelivery) {
            throw OrderException::PaymentMethodNotSupportedException();
        }

        return DB::transaction(
            callback: function () use ($data): DetailedOrderData {

                $orderRouteModel = TemporaryOrderRoute::query()->with('checkpoints')
                    ->findOrFail($data->orderRouteId);

                $deliveryPrice = $this->priceCalculationService->calculateOrderPrice(
                    weight: $data->weight,
                    dimensions: $data->dimensions,
                    distance: new Distance($orderRouteModel->total_distance),
                    packageValue: $data->packageValue
                );

                $checkpoints = $orderRouteModel->checkpoints->sortBy('checkpoint_number')->values();
                //create order
                $orderModel = Order::create(
                    attributes: [
                        'start_station_id' => $checkpoints->first()->checkpoint_id,
                        'end_station_id' => $checkpoints->last()->checkpoint_id,
                        'customer_id' => $data->customerId,
                        'code' => bin2hex(random_bytes(5)),
                        'sender_name' => $data->senderName,
                        'sender_phone' => $data->senderPhone,
                        'sender_email' => $data->senderEmail,
                        'receiver_name' => $data->receiverName,
                        'receiver_phone' => $data->receiverPhone,
                        'receiver_email' => $data->receiverEmail,
                        'note' => $data->note,
                        'package_value' => $data->packageValue,
                        'delivery_price' => $deliveryPrice,
                        'weight' => $data->weight->value(),
                        'height' => $data->dimensions->height(),
                        'length' => $data->dimensions->length(),
                        'width' => $data->dimensions->width(),
                        'package_types' => $data->packageTypes,
                        'payment_method' => $data->paymentMethod,
                        'collect_on_delivery' => $data->collectOnDelivery,
                        'receive_token' => Order::generateToken(),
                    ],
                );

                $checkpointData = $orderRouteModel->checkpoints->map(
                    fn ($checkpoint) => collect($checkpoint->toArray())->only(['checkpoint_id', 'checkpoint_type', 'checkpoint_number', 'distance_from_previous', 'distance_percentage'])->toArray()
                );
                //create checkpoints
                $routeCheckpointModels = $orderModel->routeCheckpoints()->createMany($checkpointData);
                $firstCheckpoint = $routeCheckpointModels->first();
                $firstCheckpoint->permissions()->createMany(
                    [
                        [
                            'permission' => OrderStatus::Accepted,
                            'permission_number' => 1,
                        ],
                        [
                            'permission' => OrderStatus::Delivering,
                            'permission_number' => 2,
                        ],
                    ]
                );
                $lastCheckpoint = $routeCheckpointModels->last();
                $lastCheckpoint->permissions()->createMany(
                    [
                        [
                            'permission' => OrderStatus::Delivered,
                            'permission_number' => 1,
                        ],
                        [
                            'permission' => OrderStatus::Done,
                            'permission_number' => 2,
                        ],
                    ]
                );

                $otherCheckpoints = $routeCheckpointModels->reject(fn ($item) => $item->id === $firstCheckpoint->id || $item->id === $lastCheckpoint->id)
                    ->each(
                        fn ($checkpoint) => $checkpoint->permissions()->createMany(
                            [
                                [
                                    'permission' => OrderStatus::Delivered,
                                    'permission_number' => 1,
                                ],
                                [
                                    'permission' => OrderStatus::Delivering,
                                    'permission_number' => 2,
                                ],
                            ]
                        )
                    );

                OrderCreated::dispatch(
                    $orderModel,
                    CarbonImmutable::now(),
                );

                return DetailedOrderData::fromModel(
                    model: $orderModel,
                    checkpoints: $checkpoints,
                    startStation: StationData::fromModel($orderModel->startStation),
                    endStation: StationData::fromModel($orderModel->endStation)
                );
            },
            attempts: 3
        );
    }
}
