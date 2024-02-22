<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Transaction\Read;

use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Domain\Shared\Constants\DefaultConstant;
use Domain\Partner\DataTransferObjects\Transaction\TransactionData;

interface GetTransactionContract
{
    /**
     * @return PaginationContract<TransactionData>
     */
    public function handle(
        int $partnerId,
        ?int $page = null,
        ?int $perPage = DefaultConstant::PER_PAGE
    ): PaginationContract;
}
