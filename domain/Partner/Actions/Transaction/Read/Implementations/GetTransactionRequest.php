<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Transaction\Read\Implementations;

use App\Models\TransactionRequest;
use Domain\Partner\Actions\Transaction\Read\GetTransactionRequestContract;
use Domain\Partner\DataTransferObjects\Transaction\TransactionRequestData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class GetTransactionRequest implements GetTransactionRequestContract
{
    /**
     * @return PaginationContract<TransactionRequestData>
     */
    public function handle(
        int $partnerId,
        PagingData $pagingData
    ): PaginationContract
    {
        $query = TransactionRequest::withCount('transaction')
            ->where('partner_id', $partnerId)
            ->orderByDesc('created_at');
        return QueryBuilder::for(
                subject: $query
            )
            ->allowedFilters(
                filters: [
                    AllowedFilter::scope('amount_between'),
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::scope('type'),
                    AllowedFilter::scope('is_proceeded'),
                ]
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            )->through(
                callback: fn (TransactionRequest $model) => TransactionRequestData::fromModel($model, $model->transaction_count > 0)
            );
    }
}
