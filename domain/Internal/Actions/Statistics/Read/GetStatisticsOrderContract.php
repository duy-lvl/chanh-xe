<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read;

use Domain\Internal\DataTransferObjects\Statistics\OrderData;

interface GetStatisticsOrderContract
{
    public function handle(): OrderData;
}
