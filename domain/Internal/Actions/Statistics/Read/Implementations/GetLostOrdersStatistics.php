<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read\Implementations;

use App\Models\Order;
use Domain\Internal\Actions\Statistics\Read\GetLostOrdersStatisticsContract;

final class GetLostOrdersStatistics implements GetLostOrdersStatisticsContract
{
    public function handle(): int
    {
        return Order::query()->where('is_lost', true)->count();

    }
}
