<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read;

use Domain\Internal\DataTransferObjects\Balance\PartnerWithdrawStatisticsData;
use Illuminate\Support\Collection;

interface GetPartnerWithdrawStatisticsContract
{
    /**
     * @return Collection<PartnerWithdrawStatisticsData>
     */
    public function handle(int $year): Collection;
}
