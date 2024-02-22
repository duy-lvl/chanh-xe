<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Vehicle\Read\Implementations;

use App\Models\Vehicle;
use Spatie\QueryBuilder\QueryBuilder;
use Domain\Internal\Actions\Vehicle\Read\GetVehicleContract;
use Domain\Internal\DataTransferObjects\Vehicle\VehicleData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\AllowedFilter;

final class GetVehicle implements GetVehicleContract
{
    /**
     * @return PaginationContract<VehicleData>
     */
    public function handle(int $partnerId, PagingData $pagingData): PaginationContract
    {
        return QueryBuilder::for(
            subject: Vehicle::query()->with('partner')->where('partner_id', $partnerId)->orderByDesc('created_at'),
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
