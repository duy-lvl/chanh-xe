<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read\Implementations;

use App\Models\Transaction;
use Domain\Internal\Actions\Balance\Read\GetPartnerTopUpStatisticsContract;
use Domain\Internal\DataTransferObjects\Balance\PartnerTopUpStatisticsData;
use Domain\Partner\Enums\TransactionRequestType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class GetPartnerTopUpStatistics implements GetPartnerTopUpStatisticsContract
{
    /**
     * @return Collection<PartnerTopUpStatisticsData>
     */
    public function handle(int $year): Collection
    {
        $transactions = Transaction::query()
            ->selectRaw('SUM(amount) as amount')
            ->addSelect(DB::raw('EXTRACT(MONTH FROM transactions.created_at) as month_key'))
            ->whereNotNull('request_id')
            ->whereRelation('request', 'type', '=', TransactionRequestType::Topup)
            ->whereYear('created_at', $year)
            ->groupByRaw('EXTRACT(MONTH FROM transactions.created_at)')
            ->get();

        $transactions = $transactions->map(fn ($item) => new PartnerTopUpStatisticsData((int) $item->month_key, (int) $item->amount));

        $result = collect();

        for ($i = 1; $i <= 12; $i++) {
            $result->push(new PartnerTopUpStatisticsData(
                $i,
                $transactions->firstWhere('month', $i) !== null ? (int) $transactions->firstWhere('month', $i)?->amount : 0,
            ));
        }

        return $result;
    }
}
