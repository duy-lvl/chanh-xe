<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Vehicle\Read\Implementations;

use App\Models\Hub;
use App\Models\Order;
use App\Models\Staff;
use App\Models\Vehicle;
use Spatie\QueryBuilder\QueryBuilder;
use Domain\Internal\Actions\Vehicle\Read\GetInComingVehicleContract;
use Domain\Internal\DataTransferObjects\Vehicle\VehicleData;
use Domain\Shared\DataTransferObjects\PagingData;

use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

final class GetInComingVehicle implements GetInComingVehicleContract
{
    /**
     * @return PaginationContract<VehicleData>
     */
    public function handle(int $staffId, PagingData $pagingData): PaginationContract
    {
        $staff = Staff::findOrFail($staffId);
        $hubId = $staff->hub_id;

        $orders = Order::query()
            ->with('routeCheckpoints')
            ->isPassThroughHub(true)
            ->isAtStartCheckpoint()
            ->status(2)           
            ->orderByDesc('orders.created_at')
            ->get();
        $vehicleIds = collect();
        foreach($orders as $order) {
            $vehicleId = $order->routeCheckpoints()
                ->select('vehicle_id')
                ->firstWhere('checkpoint_type', (new Hub())->getMorphClass());
            $vehicleIds->push($vehicleId->vehicle_id);
        }
        
        return QueryBuilder::for(
            subject: Vehicle::query()->whereIn('id', $vehicleIds->unique())->with('partner')
        )->allowedFilters(
            filters: ['plate_number', 'type', AllowedFilter::scope('partner_name')],
        )->fastPaginate(
            perPage: $pagingData->perPage,
            page: $pagingData->page,
        )->through(
            fn (Vehicle $vehicle) : VehicleData => VehicleData::fromModel($vehicle, $vehicle->partner->name)
        );
    }
}
