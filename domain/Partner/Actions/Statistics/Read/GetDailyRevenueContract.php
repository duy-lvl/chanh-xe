<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Statistics\Read;

use Domain\Internal\DataTransferObjects\Statistics\DayRevenueData;
use Illuminate\Support\Collection;

interface GetDailyRevenueContract
{
    /** @return Collection<DayRevenueData> */
    public function handle(int $year, int $month, int $partnerId): Collection;
}
