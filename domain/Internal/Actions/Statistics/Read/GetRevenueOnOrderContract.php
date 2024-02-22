<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read;

use Illuminate\Support\Collection;

interface GetRevenueOnOrderContract
{
    public function handle(int $year): Collection;
}
