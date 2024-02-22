<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Account\Read;

use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetStaffAccountContract
{
    /**
     * @return PaginationContract<\Domain\Internal\DataTransferObjects\Account\StaffAccountData>
     */
    public function handle(int $adminId, PagingData $pagingData): PaginationContract;
}
