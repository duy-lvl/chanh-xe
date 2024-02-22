<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Account\Read\Implementations;

use App\Models\Customer;
use Domain\Internal\Actions\Account\Read\GetCustomerAccountContract;
use Domain\Internal\DataTransferObjects\Account\CustomerAccountData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class GetCustomerAccount implements GetCustomerAccountContract
{
    /**
     * @return PaginationContract<\Domain\Internal\DataTransferObjects\Account\CustomerAccountData>
     */
    public function handle(PagingData $pagingData): PaginationContract
    {
        $customerPaginatedCollection = QueryBuilder::for(
                subject: Customer::query()->orderByDesc('created_at')
            )
            ->allowedFilters(
                filters: [
                    'phone',
                    'name',
                    'email',
                    AllowedFilter::exact('status'),
                ]
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            );

        return $customerPaginatedCollection->through(
            callback: fn (Customer $customer) => CustomerAccountData::fromModel($customer)
        );
    }
}
