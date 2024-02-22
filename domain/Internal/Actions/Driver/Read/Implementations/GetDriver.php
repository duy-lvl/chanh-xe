<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Driver\Read\Implementations;

use App\Models\Driver;
use Spatie\QueryBuilder\QueryBuilder;
use Domain\Internal\Actions\Driver\Read\GetDriverContract;
use Domain\Internal\DataTransferObjects\Driver\DriverData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\AllowedFilter;

final class GetDriver implements GetDriverContract
{
    public function handle(int $partnerId, PagingData $pagingData): PaginationContract
    {
        return QueryBuilder::for(
            subject: Driver::query()->with('partner')->where('partner_id', $partnerId)->orderByDesc('created_at'),
        )->allowedFilters(
            filters: ['name', 'phone', AllowedFilter::scope('partner_name')],
        )->fastPaginate(
            perPage: $pagingData->perPage,
            page: $pagingData->page,
        )->through(
            fn (Driver $driver) : DriverData => DriverData::fromModel($driver, $driver->partner->name)
        );
    }
}
