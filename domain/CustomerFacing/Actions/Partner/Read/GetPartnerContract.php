<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Partner\Read;

use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetPartnerContract
{
    /**
     * @return PaginationContract<\Domain\CustomerFacing\DataTransferObjects\Partner\PartnerData>
     */
    public function handle(PagingData $pagingData): PaginationContract;
}
