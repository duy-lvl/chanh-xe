<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Vehicle\Read\Implementations;

use App\Models\Vehicle;
use Spatie\QueryBuilder\QueryBuilder;
use Domain\Partner\Actions\Vehicle\Read\GetVehicleContract;
use Domain\Partner\DataTransferObjects\Vehicle\VehicleData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

final class GetVehicle implements GetVehicleContract
{
    public function handle(PagingData $pagingData, int $partnerId): PaginationContract
    {
        return QueryBuilder::for(
            subject: Vehicle::query()->where('partner_id', $partnerId)->orderByDesc('created_at'),
        )->allowedFilters(
            filters: ['plate_number', 'type'],
        )->fastPaginate(
            perPage: $pagingData->perPage,
            page: $pagingData->page,
        )->through(
            fn (Vehicle $vehicle) : VehicleData => VehicleData::fromModel($vehicle)
        );
    }
}
