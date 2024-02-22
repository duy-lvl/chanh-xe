<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read\Implementations;

use App\Models\Transaction;
use Domain\Internal\Actions\Balance\Read\GetTransactionListContract;
use Domain\Internal\DataTransferObjects\Account\PartnerAccountData;
use Domain\Internal\DataTransferObjects\Balance\TransactionData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class GetTransactionList implements GetTransactionListContract
{
    /**
     * @return PaginationContract<TransactionData>
     */
    public function handle(PagingData $pagingData): PaginationContract
    {
        $query = Transaction::query()->with('wallet.partner')->orderByDesc('created_at');


        $transactionPaginatedCollection = QueryBuilder::for(subject: $query)
            ->allowedFilters(
                filters: [
                    AllowedFilter::scope('amount_between'),
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::scope('type'),
                ]
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            );

        return $transactionPaginatedCollection
            ->through(
                callback: fn (Transaction $transaction) => TransactionData::fromModel(model: $transaction, partner: $transaction->wallet->partner)
            );
    }
}
