<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read\Implementations;

use App\Models\Order;
use App\Models\Partner;
use App\Models\Transaction;
use Carbon\Carbon;
use DB;
use Domain\Internal\Actions\Statistics\Read\GetRevenueOnOrderContract;
use Domain\Internal\Actions\Statistics\Read\GetWithdrawContract;
use Domain\Internal\DataTransferObjects\Statistics\MonthRevenueData;
use Domain\Partner\Enums\TransactionRequestType;
use Illuminate\Support\Collection;

final class GetRevenueOnOrder implements GetRevenueOnOrderContract
{

    public function handle(int $year): Collection
    {

        $orderThroughHubs = Order::query()
            ->whereYear('created_at', $year)
            
            ->select(DB::raw('sum(delivery_price)'))
            ->addSelect(DB::raw("extract(month from transactions.created_at) as month_query"))
            ->groupByRaw('month_query')
            ->get();
        $orders = Order::query()
            ->whereYear('created_at', $year)
            ->select(DB::raw('sum(delivery_price)'))
            ->addSelect(DB::raw("extract(month from transactions.created_at) as month_query"))
            ->groupByRaw('month_query')
            ->get();
        $result = collect();
     
        for ($i=1; $i<=12; $i++) {
            $result->push(new MonthRevenueData(month: $i, revenue: 0));
        }
        
            // ->get();
        foreach($orders as $order) {
            $month = (new Carbon($order->month_query))->month;
            $total = $order->sum;
            $result[$month-1]->revenue = $total;
        }
            
        
        dd($result->first());
        return $result;
    }
}
