<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Hub\Read;

use Domain\Shared\Constants\DefaultConstant;
use Domain\Partner\DataTransferObjects\Hub\HubData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetHubContract
{
    /**
     * @return PaginationContract<HubData>
     */
    public function handle(?int $page = null, ?int $perPage = DefaultConstant::PER_PAGE): PaginationContract;
}
