<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read;

use Domain\Internal\DataTransferObjects\Balance\PartnerAccountBalanceStatisticsData;
use Illuminate\Support\Collection;

interface GetPartnerAccountBalanceStatisticsContract
{
    public function handle(): PartnerAccountBalanceStatisticsData;
}
