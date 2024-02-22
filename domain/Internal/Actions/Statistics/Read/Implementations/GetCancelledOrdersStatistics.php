<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read\Implementations;

use App\Models\Order;
use Domain\Internal\Actions\Statistics\Read\GetCancelledOrdersStatisticsContract;

final class GetCancelledOrdersStatistics implements GetCancelledOrdersStatisticsContract
{
    public function handle(): int
    {
        return Order::query()->where('is_lost', false)->where('is_cancelled', true)->count();

    }
}
