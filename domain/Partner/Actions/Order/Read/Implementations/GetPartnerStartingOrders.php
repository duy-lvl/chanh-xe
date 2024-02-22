<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Read\Implementations;

use App\Models\Hub;
use App\Models\Order;
use App\Models\OrderRouteCheckpoint;
use App\Models\OrderRoutePermission;
use App\Models\Station;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\Partner\Actions\Order\Read\GetPartnerStartingOrdersContract;
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

final class GetPartnerStartingOrders implements GetPartnerStartingOrdersContract
{
    public function __construct(
        private readonly CalculateRevenue $calculateRevenueService,
    ) {}
    public function handle(int $partnerId, PagingData $pagingData): PaginationContract
    {
        $query = Order::query()
            ->with([
                'startStation',
                'currentCheckpoint', 
                'routeCheckpoints.checkpoint',
                'routeCheckpoints.permissions',
                'routeCheckpoints.driver',
                'routeCheckpoints.vehicle',
            ])
            ->whereRelation('startStation.partner', 'id', $partnerId)
            ->where('is_cancelled', false)
            ->whereHas('routeCheckpoints', function (Builder $query) {
                $query->hasMorph('checkpoint', Hub::class);
            })
            ->whereRelation('currentCheckpoint', 'checkpoint_number', '<', 2)
            ->orderByDesc('orders.created_at');
            // ->whereHas('currentCheckpoint.permissions', function(Builder $query){
            //     $query->whereNot('achieved_at', '<>', null);
            // });
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
                    $checkpoints = $order->routeCheckpoints
                        // ->where('checkpoint_number', '<=', 2)
                        ->sortBy('checkpoint_number')->values()
                        ->map(function (OrderRouteCheckpoint $orderRouteCheckpoint) {
                            $permissions = $orderRouteCheckpoint->permissions->sortBy('permission_number')->values()->map(fn (OrderRoutePermission $permission) => PermissionData::fromModel($permission, $permission->achieved_at === null && $orderRouteCheckpoint->checkpoint_type === (new Station())->getMorphClass()));
                            
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
                    if ($order->isPaid || $order->payment_method == PaymentMethod::VnPay || $order->collect_on_delivery) {
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
