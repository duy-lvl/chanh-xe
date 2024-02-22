<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read\Implementations;

use App\Models\Partner;
use Domain\Internal\Actions\Statistics\Read\GetPartnerStatisticsContract;
use Domain\Shared\Enums\AccountStatus;

final class GetPartnerStatistics implements GetPartnerStatisticsContract
{
    public function handle(AccountStatus $status): int
    {
        return Partner::query()->where('status', $status)->count();

    }
}
