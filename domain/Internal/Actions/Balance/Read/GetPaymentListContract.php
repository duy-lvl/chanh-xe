<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read;

use Domain\Internal\DataTransferObjects\Balance\PaymentData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetPaymentListContract
{
    /**
     * @return PaginationContract<PaymentData>
     */
    public function handle(PagingData $pagingData): PaginationContract;
}
