<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read\Implementations;

use App\Models\Order;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\Internal\Actions\Statistics\Read\GetYearlyRevenueStatisticsContract;
use Domain\Internal\DataTransferObjects\Statistics\MonthRevenueData;
use Domain\Internal\DataTransferObjects\Statistics\YearlyRevenueData;
use Illuminate\Support\Collection;

final class GetYearlyRevenueStatistics implements GetYearlyRevenueStatisticsContract
{
    public function handle(int $year): Collection
    {
        $orders = Order::query()
            ->withCount('routeCheckpoints')
            ->whereYear('created_at', $year)
            ->status(OrderStatus::Done)
            ->get();

        $result = collect();

        for ($i=1; $i<=12; $i++) {
            $result->push(new YearlyRevenueData(
                month: $i,
                systemRevenue: 0,
                partnerRevenue: 0,
                companyRevenue: 0,
            ));
        }

        foreach($orders as $order) {
            $month = (int) $order->created_at->month;

            $companyPercentage = $order->route_checkpoints_count > 2 ? 0.2 : 0.05;

            $result[$month-1]->systemRevenue += (int) $order->delivery_price;
            $result[$month-1]->companyRevenue += (int) ($order->delivery_price * $companyPercentage);
            $result[$month-1]->partnerRevenue +=  (int) ($order->delivery_price * (1-$companyPercentage));
        }

        return $result;
    }
}
