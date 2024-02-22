<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Driver\Read;

use Domain\Partner\DataTransferObjects\Driver\DriverData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetDriverContract
{
    /**
     * @return PaginationContract<DriverData>
     */
    public function handle(int $partnerId, PagingData $pagingData): PaginationContract;
}
