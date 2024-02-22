<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Statistics\Read\Implementations;

use App\Models\Transaction;
use Carbon\Carbon;
use Domain\Partner\Actions\Statistics\Read\GetMonthlyRevenueContract;
use Domain\Internal\DataTransferObjects\Statistics\MonthRevenueData;
use Domain\Partner\Enums\WalletType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class GetMonthlyRevenue implements GetMonthlyRevenueContract
{
    /** @return Collection<MonthRevenueData> */
    public function handle(int $year, int $partnerId): Collection
    {
        $revenues = Transaction::query()
            ->select(DB::raw('sum(amount)'))
            ->addSelect(DB::raw("date_trunc('month', created_at) as month_query"))
            
            ->whereRelation('wallet', fn (Builder $query) => $query->where('type', WalletType::Revenue)->where('partner_id', $partnerId))
            ->whereYear('created_at', $year)
            ->groupByRaw('month_query')
            ->get();
            // ->sum('amount');
        
        // dd($revenues->all());
        // return $revenues->map(function ($revenue) {
            
        //     $month = (new Carbon($revenue->month_query))->month;
        //     $total = (int)$revenue->sum;
        //     return new MonthRevenueData(month: $month, revenue: $total);
        // }); 

        $result = collect();
        for ($i=1; $i<=12; $i++) {
            $result->push(new MonthRevenueData(month: $i, revenue: 0));
        }
        foreach($revenues as $revenue) {
            $month = (new Carbon($revenue->month_query))->month;
            $total = (int)$revenue->sum;
            $result[$month-1]->revenue = $total;
        }
        return $result;
    }
}
