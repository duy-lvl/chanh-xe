<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Account\Read\Implementations;

use App\Models\Staff;
use Domain\Internal\Actions\Account\Read\GetStaffAccountContract;
use Domain\Internal\DataTransferObjects\Account\StaffAccountData;
use Domain\Internal\DataTransferObjects\Hub\HubData;
use Domain\Internal\Enums\StaffRole;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\QueryBuilder;

final class GetStaffAccount implements GetStaffAccountContract
{
    /**
     * @return PaginationContract<StaffAccountData>
     */
    public function handle(int $adminId, PagingData $pagingData): PaginationContract
    {
        $query = Staff::query()->with(['hub'])->withoutRole(StaffRole::Manager, 'api_internal')->whereNot('id', $adminId)->orderByDesc('created_at');

        $staffPaginatedCollection = QueryBuilder::for(
                subject: $query
            )
            ->allowedFilters(
                filters: [
                    'username',
                    'email',
                    'hub_id',
                ]
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            );

        return $staffPaginatedCollection->through(
            callback: fn (Staff $staff) => StaffAccountData::fromModel($staff, HubData::fromModel($staff->hub))
        );
    }
}
