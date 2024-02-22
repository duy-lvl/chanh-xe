<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Account\Read;

use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetPartnerAccountContract
{
    /**
     * @return PaginationContract<\Domain\Internal\DataTransferObjects\Account\PartnerAccountData>
     */
    public function handle(PagingData $pagingData): PaginationContract;
}
