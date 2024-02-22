<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read\Implementations;

use App\Models\Payment;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\Internal\Actions\Balance\Read\GetCustomerDirectPaymentStatisticsContract;
use Domain\Internal\DataTransferObjects\Balance\CustomerDirectPaymentStatisticsData;
use Domain\Partner\Enums\PaymentRequestType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class GetCustomerDirectPaymentStatistics implements GetCustomerDirectPaymentStatisticsContract
{
    /**
     * @return Collection<CustomerDirectPaymentStatisticsData>
     */
    public function handle(int $year): Collection
    {
        $payments = Payment::query()
            ->selectRaw('SUM(value) as amount')
            ->addSelect(DB::raw('EXTRACT(MONTH FROM created_at) as month_key'))
            ->whereNot('payment_method', PaymentMethod::Cash)
            ->whereYear('created_at', $year)
            ->groupByRaw('EXTRACT(MONTH FROM created_at)')
            ->get();

        $payments = $payments->map(fn ($item) => new CustomerDirectPaymentStatisticsData((int) $item->month_key, (int) $item->amount));

        $result = collect();

        for ($i = 1; $i <= 12; $i++) {
            $result->push(new CustomerDirectPaymentStatisticsData(
                $i,
                $payments->firstWhere('month', $i) !== null ? (int) $payments->firstWhere('month', $i)?->amount : 0,
            ));
        }

        return $result;
    }
}
