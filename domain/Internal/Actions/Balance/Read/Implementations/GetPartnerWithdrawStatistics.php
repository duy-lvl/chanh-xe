<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read\Implementations;

use App\Models\Transaction;
use Domain\Internal\Actions\Balance\Read\GetPartnerWithdrawStatisticsContract;
use Domain\Internal\DataTransferObjects\Balance\PartnerWithdrawStatisticsData;
use Domain\Partner\Enums\TransactionRequestType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class GetPartnerWithdrawStatistics implements GetPartnerWithdrawStatisticsContract
{
    /**
     * @return Collection<PartnerWithdrawStatisticsData>
     */
    public function handle(int $year): Collection
    {
        $transactions = Transaction::query()
            ->selectRaw('SUM(amount) as amount')
            ->addSelect(DB::raw('EXTRACT(MONTH FROM transactions.created_at) as month_key'))
            ->whereNotNull('request_id')
            ->whereRelation('request', 'type', '=', TransactionRequestType::Withdraw)
            ->whereYear('created_at', $year)
            ->groupByRaw('EXTRACT(MONTH FROM transactions.created_at)')
            ->get();

        $transactions = $transactions->map(fn ($item) => new PartnerWithdrawStatisticsData((int) $item->month_key, (int) $item->amount));

        $result = collect();

        for ($i = 1; $i <= 12; $i++) {
            $result->push(new PartnerWithdrawStatisticsData(
                $i,
                $transactions->firstWhere('month', $i) !== null ? (int) $transactions->firstWhere('month', $i)?->amount : 0,
            ));
        }

        return $result;
    }
}
