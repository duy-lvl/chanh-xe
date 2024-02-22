<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Read\Implementations;

use App\Models\Hub;
use App\Models\Order;
use App\Models\OrderRouteCheckpoint;
use App\Models\OrderRoutePermission;
use App\Models\Station;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\Partner\Actions\Order\Read\GetPartnerEndingOrdersContract;
use Domain\Partner\DataTransferObjects\Order\DriverData;
use Domain\Partner\DataTransferObjects\Order\CheckpointData;
use Domain\Partner\DataTransferObjects\Order\OrderData;
use Domain\Partner\DataTransferObjects\Order\PermissionData;
use Domain\Partner\DataTransferObjects\Order\VehicleData;
use Domain\Partner\Services\CalculateRevenue;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

final class GetPartnerEndingOrders implements GetPartnerEndingOrdersContract
{
    public function __construct(
        private readonly CalculateRevenue $calculateRevenueService,
    ) {}
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
            ->whereRelation('endStation.partner', 'id', $partnerId)
            ->where('is_cancelled', false)
            ->whereHas(relation: 'routeCheckpoints', callback: function ($query) {
                $query->where('checkpoint_type', (new Hub())->getMorphClass());
            })
            // ->whereRelation('currentCheckpoint', 'checkpoint_number', '>', 1)
            ->whereHas('lastCheckpoint.permissions', function(Builder $query){
                $query->where('achieved_at', null);
            })
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
                    $checkpoints = $order->routeCheckpoints->where('checkpoint_number', '>=', 2)
                        ->sortBy('checkpoint_number')->values()
                        ->map(function (OrderRouteCheckpoint $orderRouteCheckpoint) use ($order){
                            $updatable = false;
                            if ($orderRouteCheckpoint->checkpoint_type === (new Station())->getMorphClass()) {
                                $previousCheckpoint = $order->routeCheckpoints->where('checkpoint_number', $orderRouteCheckpoint->checkpoint_number-1)->first();
                               
                                $updatable = $previousCheckpoint->permissions->where('achieved_at', null)->count() === 0;
                            }
                            $permissions = $orderRouteCheckpoint->permissions->sortBy('permission_number')->values()->map(
                                fn (OrderRoutePermission $permission) => PermissionData::fromModel(
                                    $permission, 
                                    $updatable && $permission->achieved_at === null 
                                
                                ));
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
                    $revenue = $this->calculateRevenueService->calculateRevenue($order, $partnerId);
                    return OrderData::fromModel(
                        model: $order,
                        checkpoints: $checkpoints,
                        deliveryPrice: $deliveryPrice,
                        revenue: $revenue
                    );
                }
            );
    }

}
