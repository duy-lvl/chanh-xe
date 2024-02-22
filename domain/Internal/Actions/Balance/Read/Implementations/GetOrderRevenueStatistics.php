<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read\Implementations;

use App\Models\Hub;
use App\Models\Order;
use Domain\Internal\Actions\Balance\Read\GetOrderRevenueStatisticsContract;
use Domain\Internal\DataTransferObjects\Balance\OrderRevenueStatisticsData;
use Domain\Partner\Enums\TransactionRequestType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class GetOrderRevenueStatistics implements GetOrderRevenueStatisticsContract
{
    /**
     * @return Collection<OrderRevenueStatisticsData>
     */
    public function handle(int $year): Collection
    {
        $straightOrderRevenue = Order::query()
            ->selectRaw('SUM(delivery_price) as amount')
            ->addSelect(DB::raw('EXTRACT(MONTH FROM created_at) as month_key'))
            ->where('is_cancelled', false)
            ->whereDoesntHave('routeCheckpoints', fn ($query) => $query->where('checkpoint_type', (new Hub())->getMorphClass()))
            ->whereDoesntHave('routeCheckpoints.permissions', fn ($query) => $query->where('achieved_at', null))
            ->whereYear('created_at', $year)
            ->groupByRaw('month_key')
            ->get();

        $straightOrderRevenue = $straightOrderRevenue->map(fn ($item) => new OrderRevenueStatisticsData((int) $item->month_key, (int) round((int) $item->amount * 0.05)));

        $orderThroughHubRevenue = Order::query()
            ->selectRaw('SUM(delivery_price) as amount')
            ->addSelect(DB::raw('EXTRACT(MONTH FROM created_at) as month_key'))
            ->where('is_cancelled', false)
            ->whereHas('routeCheckpoints', fn ($query) => $query->where('checkpoint_type', (new Hub())->getMorphClass()))
            ->whereDoesntHave('routeCheckpoints.permissions', fn ($query) => $query->where('achieved_at', null))
            ->groupByRaw('month_key')
            ->get();

        $orderThroughHubRevenue = $orderThroughHubRevenue->map(fn ($item) => new OrderRevenueStatisticsData((int) $item->month_key, (int) round((int) $item->amount * 0.2)));


        $result = collect();

        for ($i = 1; $i <= 12; $i++) {
            $amount = 0;

            if($straightOrderRevenue->firstWhere('month', $i) !== null){
                $amount += (int) $straightOrderRevenue->firstWhere('month', $i)->amount;
            }

            if($orderThroughHubRevenue->firstWhere('month', $i) !== null){
                $amount += (int) $orderThroughHubRevenue->firstWhere('month', $i)->amount;
            }

            $result->push(new OrderRevenueStatisticsData(
                $i,
                $amount,
            ));
        }

        return $result;
    }
}
