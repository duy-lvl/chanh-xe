<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Driver\Read\Implementations;

use App\Models\Driver;
use Spatie\QueryBuilder\QueryBuilder;
use Domain\Partner\Actions\Driver\Read\GetDriverContract;
use Domain\Partner\DataTransferObjects\Driver\DriverData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

final class GetDriver implements GetDriverContract
{
    public function handle(PagingData $pagingData, int $partnerId): PaginationContract
    {
        return QueryBuilder::for(
            subject: Driver::query()->where('partner_id', $partnerId)->orderByDesc('created_at'),
        )->allowedFilters(
            filters: ['name', 'phone'],
        )->fastPaginate(
            perPage: $pagingData->perPage,
            page: $pagingData->page,
        )->through(
            fn (Driver $driver) : DriverData => DriverData::fromModel($driver)
        );
    }
}
