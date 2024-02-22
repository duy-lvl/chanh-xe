<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Transaction\Read\Implementations;

use App\Models\Transaction;
use Domain\Partner\Actions\Transaction\Read\GetTransactionContract;
use Domain\Partner\DataTransferObjects\Transaction\TransactionData;
use Domain\Shared\Constants\DefaultConstant;
use Domain\Shared\Services\Image;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class GetTransaction implements GetTransactionContract
{
    public function __construct(
        private readonly Image $imageService
    ) {}
    /**
     * @return PaginationContract<TransactionData>
     */
    public function handle(
        int $partnerId,
        ?int $page = null,
        ?int $perPage = DefaultConstant::PER_PAGE
    ): PaginationContract
    {
        return QueryBuilder::for(
                subject: Transaction::query()
                    ->with(['wallet', 'request'])
                    ->whereRelation('wallet.partner', 'id', $partnerId)
                    ->orderByDesc('transactions.created_at')
            )
            ->allowedFilters(
                filters: [
                    AllowedFilter::scope('amount_between'),
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::scope('type'),
                ]
            )
            ->fastPaginate(
                perPage: $perPage,
                page: $page,
            )->through(
                callback: function (Transaction $model) {
                    $imageUrl = $this->imageService->getFileTemporaryUrl($model->request?->image_url);
                    return TransactionData::fromModel($model, $imageUrl);
                } 
            );
    }
}
