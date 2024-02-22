<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read\Implementations;

use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;
use DateTime;
use DB;
use Domain\Internal\Actions\Statistics\Read\GetMonthlyRevenueContract;
use Domain\Internal\DataTransferObjects\Statistics\MonthRevenueData;
use Illuminate\Support\Collection;

final class GetMonthlyRevenue implements GetMonthlyRevenueContract
{
    /** @return Collection<MonthRevenueData> */
    public function handle(int $year): Collection
    {
        $payments = Payment::query()
            ->select(DB::raw('sum(value)'))
            ->addSelect(DB::raw("date_trunc('month', created_at) as month_query"))
            ->whereYear('created_at', $year)
            ->groupByRaw('month_query')
            ->get();

        $transactions = Transaction::query()
            ->select(DB::raw('sum(amount)'))
            ->addSelect(DB::raw("date_trunc('month', created_at) as month_query"))
            ->whereYear('created_at', $year)
            ->groupByRaw('month_query')
            ->get();
        // $payments = Payment::select
        //     (
        //         DB::raw('sum(value) as sums'), 
        //         DB::raw("date_trunc('year', created_at) as year_key"),
        //         DB::raw("date_trunc('month', created_at) as month_key")
        //     )
        //     ->whereBetween('created_at', [$dateFrom, $dateTo])
        //     ->groupByRaw('year_key, month_key')            
        //     ->orderByRaw('year_key asc, month_key asc')
        //     ->get();
        
        // $transactions = Transaction::select
        //     (
        //         DB::raw('sum(amount) as sums'), 
        //         DB::raw("date_trunc('year', created_at) as year_key"),
        //         DB::raw("date_trunc('month', created_at) as month_key")
        //     )
        //     ->whereBetween('created_at', [$dateFrom, $dateTo])
        //     ->whereRelation('wallet', fn (Builder $query) => $query->where('type', WalletType::Revenue))
        //     ->groupByRaw('year_key, month_key')            
        //     ->orderByRaw('year_key asc, month_key asc')
        //     ->get();
            
        // $revenues = collect();
        // foreach($payments as $payment) {
            
        //     $revenues->push(new MonthRevenueData(
        //         month: (new Carbon($payment->month_query))->month,
        //         revenue: $payment->sum - $transactions->where('month_query', $payment->month_query)?->first()->sum
        //     ));
        // }
        
        // return $revenues;


        $result = collect();
        for ($i=1; $i<=12; $i++) {
            $result->push(new MonthRevenueData(month: $i, revenue: 0));
        }
        foreach($payments as $payment) {
            $month = (new Carbon($payment->month_query))->month;
            $total = $payment->sum - $transactions->where('month_query', $payment->month_query)?->first()->sum;
            $result[$month-1]->revenue = $total;
        }
        return $result;
    }
}
