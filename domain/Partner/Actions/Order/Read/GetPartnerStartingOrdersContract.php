<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Read;

use Domain\Shared\DataTransferObjects\PagingData;
use Domain\Partner\DataTransferObjects\Order\OrderData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetPartnerStartingOrdersContract
{
    /**
     * @return PaginationContract<OrderData>
     */
    public function handle(
        int $partnerId,
        PagingData $pagingData,
    ): PaginationContract;
}
