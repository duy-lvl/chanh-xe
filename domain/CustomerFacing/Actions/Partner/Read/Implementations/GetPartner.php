<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Partner\Read\Implementations;

use App\Models\Partner;
use App\Models\PartnerPhone;
use Domain\CustomerFacing\Actions\Partner\Read\GetPartnerContract;
use Domain\CustomerFacing\DataTransferObjects\Partner\PartnerData;
use Domain\Shared\DataTransferObjects\PagingData;
use Domain\Shared\Enums\AccountStatus;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\QueryBuilder;

final class GetPartner implements GetPartnerContract
{
    /**
     * @return PaginationContract<\Domain\CustomerFacing\DataTransferObjects\Partner\PartnerData>
     */
    public function handle(PagingData $pagingData): PaginationContract
    {
        $partnerPaginatedCollection = QueryBuilder::for(
                subject: Partner::query()->where('status', AccountStatus::Active)
            )
            ->allowedFilters(
                filters: [
                    'name',
                ]
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            );

        return $partnerPaginatedCollection->through(
            callback: function (Partner $partner) {
                // $phones = $partner->phones->map(fn (PartnerPhone $phone) => $phone->phone);
                return PartnerData::fromModel($partner);
            }
        );
    }
}
