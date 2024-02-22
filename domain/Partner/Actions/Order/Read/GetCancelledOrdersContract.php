<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Read;

use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetCancelledOrdersContract
{
    /**
     * @return PaginationContract<\Domain\Partner\DataTransferObjects\Order\OrderData>
     */
    public function handle(int $partnerId, PagingData $pagingData): PaginationContract;
}
