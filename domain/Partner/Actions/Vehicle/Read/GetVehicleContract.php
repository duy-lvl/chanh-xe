<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Vehicle\Read;

use Domain\Partner\DataTransferObjects\Vehicle\VehicleData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetVehicleContract
{
    /**
     * @return PaginationContract<VehicleData>
     */
    public function handle(PagingData $pagingData, int $partnerId): PaginationContract;
}
