<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Read;

use Domain\CustomerFacing\DataTransferObjects\Order\PaymentData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetOrderPaymentsContract
{
    /**
     * @return PaginationContract<PaymentData>
     */
    public function handle(string $code): PaginationContract;
}
