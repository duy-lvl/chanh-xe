<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Transaction\Read;

use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Domain\Partner\DataTransferObjects\Transaction\TransactionRequestData;
use Domain\Shared\DataTransferObjects\PagingData;

interface GetTransactionRequestContract
{
    /**
     * @return PaginationContract<TransactionRequestData>
     */
    public function handle(
        int $partnerId,
        PagingData $pagingData
    ): PaginationContract;
}
