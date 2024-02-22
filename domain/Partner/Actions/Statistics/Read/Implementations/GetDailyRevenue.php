<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Statistics\Read\Implementations;

use App\Models\Transaction;
use Carbon\Carbon;
use DB;
use Domain\Internal\DataTransferObjects\Statistics\DayRevenueData;
use Domain\Partner\Actions\Statistics\Read\GetDailyRevenueContract;
use Domain\Partner\Enums\WalletType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class GetDailyRevenue implements GetDailyRevenueContract
{
    /** @return Collection<DayRevenueData> */
    public function handle(int $year, int $month, int $partnerId): Collection
    {
        $revenues = Transaction::query()
            ->select(DB::raw('sum(amount)'))
            ->addSelect(DB::raw("date_trunc('day', created_at) as day_query"))
            ->whereRelation('wallet', fn (Builder $query) => $query->where('type', WalletType::Revenue)->where('partner_id', $partnerId))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupByRaw('day_query')
            ->get();
        $result = collect();
        $temp = Carbon::createFromDate($year,$month,1);
        
        for ($i=1; $i<=$temp->daysInMonth; $i++) {
            $result->push(new DayRevenueData(day: $i, revenue: 0));
        }
        foreach($revenues as $revenue) {
            $day = (new Carbon($revenue->day_query))->day;
            $total = (int)$revenue->sum;
            $result[$day-1]->revenue = $total;
        }
        return $result;
        
    }
}
