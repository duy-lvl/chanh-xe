<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Order\Read\Implementations;

use App\Models\Hub;
use App\Models\Order;
use App\Models\OrderRouteCheckpoint;
use App\Models\OrderRoutePermission;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\Internal\Actions\Order\Read\GetCancelledOrdersContract;
use Domain\Internal\Actions\Order\Read\GetDoneOrdersContract;
use Domain\Partner\DataTransferObjects\Order\CheckpointData;
use Domain\Internal\DataTransferObjects\Order\OrderData;
use Domain\Partner\DataTransferObjects\Order\DriverData;
use Domain\Partner\DataTransferObjects\Order\PermissionData;
use Domain\Partner\DataTransferObjects\Order\VehicleData;
use Domain\Partner\Services\CalculateRevenue;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class GetCancelledOrders implements GetCancelledOrdersContract
{
    public function __construct(
        private readonly CalculateRevenue $calculateRevenueService
    ) {}
    /**
     * @return PaginationContract<OrderData>
     */
    public function handle(PagingData $pagingData): PaginationContract
    {
        $query = Order::query()
                ->with([
                    'currentCheckpoint', 
                    'routeCheckpoints.checkpoint',
                    'routeCheckpoints.permissions',
                    'routeCheckpoints.driver',
                    'routeCheckpoints.vehicle',
                    'firstCheckpoint.checkpoint',
                    'lastCheckpoint.checkpoint'
                ])
                
                ->where('is_cancelled', true)
                ->orderByDesc('created_at');
        $orderPaginatedCollection = QueryBuilder::for(
               subject: $query,
            )
            ->allowedFilters(
                filters: [
                    'code',
                    AllowedFilter::scope('start_partner_name'),
                    AllowedFilter::scope('end_partner_name'),
                    AllowedFilter::scope('is_at_start_checkpoint'),
                    'sender_name',
                    'sender_phone',
                    'receiver_name',
                    'receiver_phone',
                    AllowedFilter::scope('customer_name'),
                    AllowedFilter::scope('customer_phone'),
                    AllowedFilter::scope('payment_status'),
                    AllowedFilter::exact('package_value'),
                    AllowedFilter::scope('weight_between'),
                    AllowedFilter::scope('height_between'),
                    AllowedFilter::scope('length_between'),
                    AllowedFilter::scope('width_between'),
                    AllowedFilter::scope('is_pass_through_hub'),
                ]
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            );

        //Map from collection of Orders model to collection of StartingOrderData
        return $orderPaginatedCollection
            ->through(
                callback: function (Order $order) {
                    $checkpoints = $order->routeCheckpoints
                    ->sortBy('checkpoint_number')->values()                        
                    ->map(function (OrderRouteCheckpoint $orderRouteCheckpoint){
                        
                        $permissions = $orderRouteCheckpoint->permissions->sortBy('permission_number')->values()->map(
                            fn (OrderRoutePermission $permission) => PermissionData::fromModel(
                                $permission, 
                                false
                            )
                        );
                        $driver = null;
                            $vehicle = null;
                            if ($orderRouteCheckpoint->driver !== null)
                            {
                                $driver = DriverData::fromModel($orderRouteCheckpoint->driver);
                            }
                            if ($orderRouteCheckpoint->vehicle !== null)
                            {
                                $vehicle = VehicleData::fromModel($orderRouteCheckpoint->vehicle);
                            }
                        return CheckpointData::fromModel($orderRouteCheckpoint->checkpoint, $permissions, $driver, $vehicle);
                    });


                    $deliveryPrice = (int) $order->delivery_price;
                    if ($order->isPaid || $order->payment_method == PaymentMethod::VnPay || !$order->collect_on_delivery) {
                        $deliveryPrice = 0;
                    }
                    $firstPartnerId = $order->firstCheckpoint->checkpoint->partner_id;
                    $secondPartnerId = $order->lastCheckpoint->checkpoint->partner_id;
                    $firstPartnerRevenue = $this->calculateRevenueService->calculateRevenue($order, $firstPartnerId);
                    $secondPartnerRevenue = $this->calculateRevenueService->calculateRevenue($order, $secondPartnerId);
                    if ($firstPartnerRevenue === $secondPartnerRevenue) {
                        $secondPartnerRevenue = 0;
                    }
                    return OrderData::fromModel(
                        model: $order,
                        checkpoints: $checkpoints,
                        deliveryPrice: $deliveryPrice,
                        isPassThroughHub: $order->routeCheckpoints->where('checkpoint_type', (new Hub())->getMorphClass())->count() > 0,
                        firstPartnerRevenue: $firstPartnerRevenue,
                        secondPartnerRevenue: $secondPartnerRevenue
                    );
                }
            );
    }

}
