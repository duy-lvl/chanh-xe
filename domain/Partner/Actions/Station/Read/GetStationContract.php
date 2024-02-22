<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Station\Read;

use Domain\Partner\DataTransferObjects\Station\StationData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetStationContract
{
    /**
     * @return PaginationContract<StationData>
     */
    public function handle(
        ?int $partnerId = null,
        PagingData $pagingData,
    ): PaginationContract;
}
