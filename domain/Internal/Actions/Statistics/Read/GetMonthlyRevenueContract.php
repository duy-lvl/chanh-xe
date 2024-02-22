<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read;

use Domain\Internal\DataTransferObjects\Statistics\MonthRevenueData;
use Illuminate\Support\Collection;


interface GetMonthlyRevenueContract
{
    /** @return Collection<MonthRevenueData> */
    public function handle(int $year): Collection;
}
