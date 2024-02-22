<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Write\Implementations;

use App\Exceptions\OrderException;
use App\Models\Order;
use Domain\CustomerFacing\Actions\Order\Write\UpdateOrderContract;
use Domain\CustomerFacing\DataTransferObjects\Order\UpdateOrderData;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\PriceCalculation\Services\PriceCalculation as PriceCalculationService;
use Domain\Shared\ValueObjects\Distance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class UpdateOrder implements UpdateOrderContract
{
    public function __construct(
        private readonly PriceCalculationService $priceCalculationService,
    ) {
    }

    /**
     * @throws OrderException
     */
    public function handle(string $code, UpdateOrderData $data): void
    {
        // if ($data->paymentMethod === PaymentMethod::VnPay && $data->collectOnDelivery) {
        //     throw OrderException::PaymentMethodNotSupportedException();
        // }
        DB::transaction(
            callback: function () use ($data, $code): void {
                $order = Order::query()->where('code', Str::lower($code))->firstOrFail();

                if ($order->customer_id !== $data->customerId) {
                    throw OrderException::OrderNotBelongToCustomerException();
                }

                // $deliveryPrice = $this->priceCalculationService->calculateOrderPrice(
                //     weight: $data->weight,
                //     dimensions: $data->dimensions,
                //     distance: new Distance($order->total_distance),
                //     packageValue: $data->packageValue
                // );

                $order->sender_email = $data->senderEmail ?? null;
                $order->sender_name = $data->senderName;
                $order->sender_phone = $data->senderPhone;
                $order->receiver_email = $data->receiverEmail ?? null;
                $order->receiver_phone = $data->receiverPhone;
                $order->receiver_name = $data->receiverName;
                // $order->note = $data->note ?? null;
                // $order->package_value = $data->packageValue;
                // $order->delivery_price = $deliveryPrice;
                // $order->weight = $data->weight->value();
                // $order->height = $data->dimensions->height();
                // $order->length = $data->dimensions->length();
                // $order->width = $data->dimensions->width();
                // $order->payment_method = $data->paymentMethod;
                // $order->collect_on_delivery = $data->collectOnDelivery;
                
                //save order
                $is_updated = $order->save();

                if (!$is_updated) {
                    throw OrderException::UpdateOrderFailedException();
                }

                // OrderCreated::dispatch(
                //     $order,
                //     CarbonImmutable::now(),
                // );

            },
            attempts: 3
        );
    }
}
