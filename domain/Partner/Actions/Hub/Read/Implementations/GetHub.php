<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Hub\Read\Implementations;

use App\Models\Hub;
use Spatie\QueryBuilder\QueryBuilder;
use Domain\Partner\Actions\Hub\Read\GetHubContract;
use Domain\Partner\DataTransferObjects\Hub\HubData;
use Domain\Shared\Constants\DefaultConstant;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

final class GetHub implements GetHubContract
{
    public function handle(?int $page = null, ?int $perPage = DefaultConstant::PER_PAGE): PaginationContract
    {
        return QueryBuilder::for(
            subject: Hub::class,
        )->allowedFilters(
            filters: ['name', 'address'],
        )->fastPaginate(
            perPage: $perPage,
            page: $page,
        )->through(
            fn (Hub $hub) : HubData => HubData::fromModel($hub)
        );
    }
}
