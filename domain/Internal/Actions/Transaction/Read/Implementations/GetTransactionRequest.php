<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Transaction\Read\Implementations;

use App\Models\TransactionRequest;
use Domain\Internal\Actions\Transaction\Read\GetTransactionRequestContract;
use Domain\Internal\DataTransferObjects\Account\PartnerAccountData;
use Domain\Internal\DataTransferObjects\Transaction\TransactionRequestData;
use Domain\Shared\DataTransferObjects\PagingData;
use Domain\Shared\Services\Image;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class GetTransactionRequest implements GetTransactionRequestContract
{
    public function __construct(
        private readonly Image $imageService
    ) {}
    /**
     * @return PaginationContract<TransactionRequestData>
     */
    public function handle(PagingData $pagingData): PaginationContract
    {
        $query = TransactionRequest::query()->with('partner')->withCount('transaction')->orderByDesc('created_at');


        $requestsPaginatedCollection = QueryBuilder::for(subject: $query)
            ->allowedFilters(
                filters: [
                    AllowedFilter::scope('amount_between'),
                    AllowedFilter::scope('bank_account_number'),
                    AllowedFilter::scope('bank_account_name'),
                    AllowedFilter::scope('bank_code'),
                    'partner_id',
                    'type',
                    AllowedFilter::scope('is_proceeded'),
                    AllowedFilter::scope('created_between')
                ]
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            );

        return $requestsPaginatedCollection
            ->through(
                callback: function (TransactionRequest $request) {

                    return TransactionRequestData::fromModel(
                        model: $request, 
                        partner: PartnerAccountData::fromModel($request->partner, collect()), 
                        isProceeded: $request->transaction_count > 0,
                        imageUrl: $this->imageService->getFileTemporaryUrl($request->image_url)
                    );
                }
            );
    }
}
