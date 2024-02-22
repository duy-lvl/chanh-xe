<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Read\Implementations;

use App\Models\Order;
use Domain\CustomerFacing\Actions\Order\Read\GetOrderPaymentStatusContract;
use Illuminate\Support\Str;

final class GetOrderPaymentStatus implements GetOrderPaymentStatusContract
{
    public function handle(string $code): bool
    {
        $order = Order::query()->where('code', Str::lower($code))->firstOrFail();

        return $order->isPaid;
    }
}
