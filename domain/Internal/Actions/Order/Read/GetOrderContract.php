<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Order\Read;

use Domain\Internal\DataTransferObjects\Order\OrderData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetOrderContract
{
    /**
     * @return PaginationContract<OrderData>
     */
    public function handle(int $staffId, PagingData $pagingData): PaginationContract;
}
