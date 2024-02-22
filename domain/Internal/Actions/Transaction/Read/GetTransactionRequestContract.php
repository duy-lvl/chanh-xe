<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Transaction\Read;

use Domain\Internal\DataTransferObjects\Transaction\TransactionRequestData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetTransactionRequestContract
{
    /**
     * @return PaginationContract<TransactionRequestData>
     */
    public function handle(PagingData $pagingData): PaginationContract;
}
