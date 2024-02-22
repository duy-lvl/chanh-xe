<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Payment\Read;

use Domain\CustomerFacing\DataTransferObjects\Order\PaymentData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetPaymentHistoryContract
{
    /**
     * @return PaginationContract<PaymentData>
     */
    public function handle(int $customerId, PagingData $pagingData): PaginationContract;
}