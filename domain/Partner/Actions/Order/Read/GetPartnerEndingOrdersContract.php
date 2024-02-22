<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Read;

use Domain\Partner\DataTransferObjects\Order\OrderData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetPartnerEndingOrdersContract
{
    /**
     * @return PaginationContract<OrderData>
     */
    public function handle(int $partnerId, PagingData $pagingData): PaginationContract;
}
