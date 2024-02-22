<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read;

use Domain\Internal\DataTransferObjects\Balance\TransactionData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetTransactionListContract
{
    /**
     * @return PaginationContract<TransactionData>
     */
    public function handle(PagingData $pagingData): PaginationContract;
}
