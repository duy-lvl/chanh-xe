<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read\Implementations;

use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;
use DB;
use Domain\Internal\Actions\Statistics\Read\GetMonthRevenueContract;
use Domain\Internal\DataTransferObjects\Statistics\DayRevenueData;
use Illuminate\Support\Collection;

final class GetMonthRevenue implements GetMonthRevenueContract
{
    /** @return Collection<DayRevenueData> */
    public function handle(int $year, int $month): Collection
    {
        $transactions = Transaction::query()
            ->select(DB::raw('sum(amount)'))
            ->addSelect(DB::raw("date_trunc('day', created_at) as day_query"))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupByRaw('day_query')
            ->get();

        $payments = Payment::query()
            ->select(DB::raw('sum(value)'))
            ->addSelect(DB::raw("date_trunc('day', created_at) as day_query"))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupByRaw('day_query')
            ->get();
        // $payment = Payment::select
        //     (
        //         DB::raw('sum(value) as sums'), 
        //         DB::raw("date_trunc('year', created_at) as year_key"),
        //         DB::raw("date_trunc('month', created_at) as month_key")
        //     )
        //     ->whereBetween('created_at', [$from, $to])
        //     ->groupByRaw('year_key, month_key')         
        //     ->orderByRaw('year_key asc, month_key asc')
        //     ->first();
        
        // $transaction = Transaction::select
        //     (
        //         DB::raw('sum(amount) as sums'), 
        //         DB::raw("date_trunc('year', created_at) as year_key"),
        //         DB::raw("date_trunc('month', created_at) as month_key")
        //     )
            
        //     ->whereRelation('wallet', fn (Builder $query) => $query->where('type', WalletType::Revenue))
        //     ->whereBetween('created_at', [$from, $to])
        //     ->groupByRaw('year_key, month_key')             
        //     ->orderByRaw('year_key asc, month_key asc')
        //     ->first();
        $result = collect();
        $temp = Carbon::createFromDate($year,$month,1);
        
        for ($i=1; $i<=$temp->daysInMonth; $i++) {
            $result->push(new DayRevenueData(day: $i, revenue: 0));
        }
        foreach($transactions as $transaction) {
            $day = (new Carbon($transaction->day_query))->day;
            $total = (int)$transaction->sum;
            $result[$day-1]->revenue -= $total;
        }
        foreach($payments as $payment) {
            $day = (new Carbon($payment->day_query))->day;
            $total = (int)$payment->sum;
            $result[$day-1]->revenue += $total;
        }
        return $result;
        // $revenue = new MonthRevenueData(
        //         month: (new Carbon($payment->month_key))->month,
        //         revenue: $payment->sums - $transaction->sums
        //     );
        
        
        // return $revenue;
    }
}
