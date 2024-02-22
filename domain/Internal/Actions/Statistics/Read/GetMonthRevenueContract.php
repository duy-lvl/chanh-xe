<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read;

use Domain\Internal\DataTransferObjects\Statistics\DayRevenueData;
use Domain\Internal\DataTransferObjects\Statistics\MonthRevenueData;
use Illuminate\Support\Collection;

interface GetMonthRevenueContract
{
    /** @return Collection<DayRevenueData> */
    public function handle(int $year, int $month): Collection;
}
