<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Price\Read;

use Domain\Internal\DataTransferObjects\Price\PriceData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetPriceContract
{
    /**
     * @return PaginationContract<PriceData>
     */
    public function handle(int $boxSizeId, PagingData $pagingData): PaginationContract;
}
