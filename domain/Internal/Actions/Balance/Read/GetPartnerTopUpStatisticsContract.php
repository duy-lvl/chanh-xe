<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read;

use Domain\Internal\DataTransferObjects\Balance\PartnerTopUpStatisticsData;
use Illuminate\Support\Collection;

interface GetPartnerTopUpStatisticsContract
{
    /**
     * @return Collection<PartnerTopUpStatisticsData>
     */
    public function handle(int $year): Collection;
}
