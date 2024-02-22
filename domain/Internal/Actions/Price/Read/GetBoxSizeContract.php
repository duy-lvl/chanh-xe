<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Price\Read;

use Domain\Internal\DataTransferObjects\Price\BoxSizeData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetBoxSizeContract
{
    /**
     * @return PaginationContract<BoxSizeData>
     */
    public function handle(PagingData $pagingData): PaginationContract;
}
