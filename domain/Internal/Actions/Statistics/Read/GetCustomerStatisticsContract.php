<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read;

interface GetCustomerStatisticsContract
{
    public function handle(): int;
}
