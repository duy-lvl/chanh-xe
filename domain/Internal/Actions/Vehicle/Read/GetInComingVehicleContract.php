<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Vehicle\Read;

use Domain\Partner\DataTransferObjects\Vehicle\VehicleData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetInComingVehicleContract
{
    /**
     * @return PaginationContract<VehicleData>
     */
    public function handle(int $staffId, PagingData $pagingData): PaginationContract;
}
