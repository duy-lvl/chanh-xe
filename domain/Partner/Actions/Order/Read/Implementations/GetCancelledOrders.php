<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Read\Implementations;

use App\Models\Order;
use App\Models\OrderRouteCheckpoint;
use App\Models\OrderRoutePermission;
use App\Models\Station;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\Partner\Actions\Order\Read\GetCancelledOrdersContract;
use Domain\Partner\DataTransferObjects\Order\DriverData;
use Domain\Partner\DataTransferObjects\Order\CheckpointData;
use Domain\Partner\DataTransferObjects\Order\OrderData;
use Domain\Partner\DataTransferObjects\Order\PermissionData;
use Domain\Partner\DataTransferObjects\Order\VehicleData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

final class GetCancelledOrders implements GetCancelledOrdersContract
{
    /**
     * @return PaginationContract<OrderData>
     */
    public function handle(int $partnerId, PagingData $pagingData): PaginationContract
    {
        $query = Order::query()
                ->with([
                    'endStation', 
                    'currentCheckpoint', 
                    'routeCheckpoints.checkpoint',
                    'routeCheckpoints.permissions',
                    'routeCheckpoints.driver',
                    'routeCheckpoints.vehicle',
                    
                ])
                ->where('is_cancelled', true)
                ->where(fn (Builder $query) =>
                    $query->whereRelation('endStation', 'partner_id', $partnerId)
                    ->orWhereRelation('startStation', 'partner_id', $partnerId)
                )
                ->orderByDesc('orders.created_at');
            
            
        $orderPaginatedCollection = QueryBuilder::for(
               subject: $query,
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            );

        //Map from collection of Orders model to collection of StartingOrderData
        return $orderPaginatedCollection
            ->through(
                callback: function (Order $order) use ($partnerId) {
                    $checkpoints = $order->routeCheckpoints->reject(
                        fn (OrderRouteCheckpoint $model) => 
                            $model->checkpoint_type == (new Station())->getMorphClass() 
                                && $model->checkpoint->partner_id != $partnerId
                    )
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
                    return OrderData::fromModel(
                        model: $order,
                        checkpoints: $checkpoints,
                        deliveryPrice: $deliveryPrice,
                        revenue: 0
                    );
                }
            );
    }

}
