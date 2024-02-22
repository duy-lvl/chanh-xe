<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read\Implementations;

use App\Models\Order;
use App\Models\Transaction;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\Internal\Actions\Balance\Read\GetPartnerAccountBalanceStatisticsContract;
use Domain\Internal\DataTransferObjects\Balance\PartnerAccountBalanceStatisticsData;
use Domain\Partner\Enums\TransactionRequestType;
use Domain\Partner\Enums\WalletType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class GetPartnerAccountBalanceStatistics implements GetPartnerAccountBalanceStatisticsContract
{
    public function handle(): PartnerAccountBalanceStatisticsData
    {
        $negative = Transaction::query()
            ->whereYear('created_at', '<=', now())
            // ->whereMonth('created_at', $i)
            ->whereRelation('wallet', 'type', '=', WalletType::CollectionOnBehalf)
            ->sum('amount');

        $positive = Transaction::query()
            ->whereYear('created_at', '<=', now())
            // ->whereMonth('created_at', $i)
            ->whereRelation('wallet', 'type', '<>', WalletType::CollectionOnBehalf)
            ->sum('amount');

        return new PartnerAccountBalanceStatisticsData(
            (int) $positive - (int) $negative,
            $this->getOrderTotalRevenue(),
        );
    }

    private function getOrderTotalRevenue(): int
    {
        return (int) Order::query()->status(OrderStatus::Done)->sum('delivery_price');
    }
}
