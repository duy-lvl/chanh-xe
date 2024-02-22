<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read;

use Domain\Shared\Enums\AccountStatus;

interface GetPartnerStatisticsContract
{
    public function handle(AccountStatus $status): int;
}
