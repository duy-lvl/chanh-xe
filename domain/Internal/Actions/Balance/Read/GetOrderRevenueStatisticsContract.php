<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read;

use Domain\Internal\DataTransferObjects\Balance\OrderRevenueStatisticsData;
use Illuminate\Support\Collection;

interface GetOrderRevenueStatisticsContract
{
    /**
     * @return Collection<OrderRevenueStatisticsData>
     */
    public function handle(int $year): Collection;
}
