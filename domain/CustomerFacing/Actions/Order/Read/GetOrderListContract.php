<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Read;

use Domain\CustomerFacing\DataTransferObjects\Order\CompactOrderData;
use Domain\Shared\Constants\DefaultConstant;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetOrderListContract
{
    /**
     * @return PaginationContract<CompactOrderData>
     */
    public function handle(
        int $customerId,
        ?int $page = null,
        ?int $perPage = DefaultConstant::PER_PAGE
    ): PaginationContract;
}
