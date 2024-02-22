<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read;

use Domain\Internal\DataTransferObjects\Statistics\YearlyRevenueData;
use Illuminate\Support\Collection;

interface GetYearlyRevenueStatisticsContract
{
    public function handle(int $year): Collection;
}
