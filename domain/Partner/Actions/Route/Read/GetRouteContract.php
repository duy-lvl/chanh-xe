<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Route\Read;

use Domain\Partner\DataTransferObjects\Route\RouteData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetRouteContract
{
    /**
     * @return PaginationContract<RouteData>
     */
    public function handle(
        ?int $partnerId = null,
        PagingData $pagingData
    ): PaginationContract;
}
