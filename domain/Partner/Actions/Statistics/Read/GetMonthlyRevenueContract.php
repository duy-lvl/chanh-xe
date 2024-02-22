<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Statistics\Read;

use Carbon\Carbon;
use Domain\Internal\DataTransferObjects\Statistics\MonthRevenueData;
use Illuminate\Support\Collection;

interface GetMonthlyRevenueContract
{
    /** @return Collection<MonthRevenueData> */
    public function handle(int $year, int $partnerId): Collection;
}
