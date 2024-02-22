<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Order\Read\Implementations;

use App\Models\Hub;
use App\Models\Order;
use App\Models\OrderRouteCheckpoint;
use App\Models\OrderRoutePermission;
use App\Models\Staff;
use Domain\Internal\Actions\Order\Read\GetOrderContract;
use Domain\Internal\DataTransferObjects\Order\OrderData;
use Domain\Partner\DataTransferObjects\Order\DriverData;
use Domain\Partner\DataTransferObjects\Order\CheckpointData;
use Domain\Partner\DataTransferObjects\Order\PermissionData;
use Domain\Partner\DataTransferObjects\Order\VehicleData;
use Domain\Partner\Services\CalculateRevenue;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class GetOrder implements GetOrderContract
{
    public function __construct(
        private readonly CalculateRevenue $calculateRevenueService
    ) {}
    /**
     * @return PaginationContract<OrderData>
     */
    public function handle(int $staffId, PagingData $pagingData): PaginationContract
    {
        $staff = Staff::findOrFail($staffId);
        $hubId = $staff->hub_id;

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
            ->where('is_cancelled', false)
            ->whereHas('routeCheckpoints', function (Builder $query) use ($hubId) {
                $query //->when($hubId !== null, fn($query) => $query->whereMorphRelation('checkpoint', Hub::class, 'checkpoint_id', '=', $hubId))
                    ->whereHas('permissions', function (Builder $query) {
                        $query->where('achieved_at', null);
                    });
            })
            ->when($hubId !== null, fn($query) => $query->whereHas('routeCheckpoints', fn (Builder $query) => $query->where('checkpoint_type', (new Hub)->getMorphClass())->where('checkpoint_id', $hubId)))
            ->orderByDesc('orders.created_at');

        $orderPaginatedCollection = QueryBuilder::for(subject: $query)
            ->allowedFilters(
                filters: [
                    'code',
                    AllowedFilter::scope('start_partner_name'),
                    AllowedFilter::scope('end_partner_name'),
                    AllowedFilter::scope('is_at_start_checkpoint'),
                    'is_lost',
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
                    AllowedFilter::scope('current_plate_number'),
                    AllowedFilter::scope('status'),
                ]
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            );

        //Map from collection of Orders model to collection of OrderData
        return $orderPaginatedCollection
            ->through(
                callback: function (Order $order) {
                    $checkpoints = $order->routeCheckpoints//->where('checkpoint_type', (new Hub())->getMorphClass())
                        ->sortBy('checkpoint_number')
                        ->values()
                        ->map(function (OrderRouteCheckpoint $orderRouteCheckpoint) use ($order){
                            $updatable = false;

                            if ($orderRouteCheckpoint->checkpoint_type === (new Hub())->getMorphClass()) {
                                $previousCheckpoint = $order->routeCheckpoints->where('checkpoint_number', $orderRouteCheckpoint->checkpoint_number-1)->first();

                                $updatable = $previousCheckpoint->permissions->where('achieved_at', null)->count() === 0;
                            }

                            $driver = null;
                            $vehicle = null;

                            if ($orderRouteCheckpoint->driver !== null){
                                $driver = DriverData::fromModel($orderRouteCheckpoint->driver);
                            }

                            if ($orderRouteCheckpoint->vehicle !== null){
                                $vehicle = VehicleData::fromModel($orderRouteCheckpoint->vehicle);
                            }

                            $permissions = $orderRouteCheckpoint->permissions->sortBy('permission_number')->values()->map(fn (OrderRoutePermission $permission) => PermissionData::fromModel($permission, $updatable && $permission->achieved_at === null));

                            return CheckpointData::fromModel($orderRouteCheckpoint->checkpoint, $permissions, $driver, $vehicle);
                        }
                    );
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
                        deliveryPrice: (int) $order->delivery_price,
                        isPassThroughHub: $order->routeCheckpoints->where('checkpoint_type', (new Hub())->getMorphClass())->count() > 0,
                        firstPartnerRevenue: $firstPartnerRevenue,
                        secondPartnerRevenue: $secondPartnerRevenue,
                        startPartnerId: $firstPartnerId,
                        endPartnerId: $secondPartnerId
                    );
                }
            );
    }
}
