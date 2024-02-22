<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Account\Read\Implementations;

use App\Models\Partner;
use App\Models\PartnerPhone;
use Domain\Internal\Actions\Account\Read\GetPartnerAccountContract;
use Domain\Internal\DataTransferObjects\Account\PartnerAccountData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\QueryBuilder;

final class GetPartnerAccount implements GetPartnerAccountContract
{
    /**
     * @return PaginationContract<\Domain\Internal\DataTransferObjects\Account\PartnerAccountData>
     */
    public function handle(PagingData $pagingData): PaginationContract
    {
        $partnerPaginatedCollection = QueryBuilder::for(
                subject: Partner::query()->with(['phones'])->orderByDesc('partners.created_at')
            )
            ->allowedFilters(
                filters: [
                    // 'username',
                    'name',
                ]
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            );
        
        return $partnerPaginatedCollection->through(
            callback: function (Partner $partner) {
                $phones = $partner->phones->map(fn (PartnerPhone $phone) => $phone->phone);
                return PartnerAccountData::fromModel($partner, $phones);
            } 
        );
    }
}
