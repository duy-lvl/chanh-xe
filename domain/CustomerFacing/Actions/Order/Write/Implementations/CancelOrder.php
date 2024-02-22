<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Write\Implementations;

use App\Exceptions\OrderException;
use App\Models\Order;
use Domain\CustomerFacing\Actions\Order\Write\CancelOrderContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Str;

final class CancelOrder implements CancelOrderContract
{

    public function handle(?int $customerId, ?string $identifier, string $orderCode): void
    {
        if ($customerId === null && $identifier === null) {
            throw OrderException::OrderIdentifierIsRequiredException();
        }
        DB::transaction(
            callback: function () use ($customerId, $identifier, $orderCode): void {
                $orderCode = Str::lower($orderCode);
                $orderModel = Order::query()->when(null === $customerId, function (Builder $query) use ($identifier, $orderCode) {
                    $query->where('code', $orderCode)
                        ->where('customer_id', null)
                        ->where(fn (Builder $query) =>
                            $query->where('sender_email', $identifier)
                                ->orWhere('sender_phone', $identifier)
                        );                    
                })
                ->when($customerId !== null, fn (Builder $query) => $query->where('customer_id', $customerId))
                ->where('code', $orderCode)->firstOrFail();

                if ((bool)$orderModel->is_confirmed) {
                    throw OrderException::OrderHasBeenConfirmedException();
                }
                if ((bool)$orderModel->is_cancelled) {
                    throw OrderException::OrderHasBeenCancelledException();
                }
                $orderModel->is_cancelled = true;
                $orderModel->cancelled_reason = 'Khách hàng huỷ đơn';
                $orderModel->cancelled_at = now();

                $orderModel->save();
                //send email here
            },
            attempts: 3
        );
    }
}
