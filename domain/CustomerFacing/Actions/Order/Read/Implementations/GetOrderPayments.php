<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Read\Implementations;

use App\Models\Order;
use App\Models\Payment;
use Domain\CustomerFacing\Actions\Order\Read\GetOrderPaymentsContract;
use Domain\CustomerFacing\DataTransferObjects\Order\PaymentData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Str;
final class GetOrderPayments implements GetOrderPaymentsContract
{
    /**
     * @return PaginationContract<PaymentData>
     */
    public function handle(string $code): PaginationContract
    {
        $order = Order::query()->where('code', Str::lower($code))->firstOrFail();

        return QueryBuilder::for(
            subject: $order->payments()
        )
            ->fastPaginate()
            ->through(
                fn (Payment $payment): PaymentData => PaymentData::fromModel($payment)
            );
    }
}
