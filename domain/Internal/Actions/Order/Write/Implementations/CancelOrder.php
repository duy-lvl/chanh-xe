<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Order\Write\Implementations;

use App\Events\OrderCancelled;
use App\Exceptions\OrderException;
use App\Models\Hub;
use App\Models\Order;
use App\Models\Staff;
use Domain\Internal\Actions\Order\Write\CancelOrderContract;
use Domain\Shared\DataTransferObjects\LocationData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class CancelOrder implements CancelOrderContract
{

    public function handle(int $staffId, string $orderCode, string $reason): void
    {
        DB::transaction(
            callback: function () use ($staffId, $orderCode, $reason): void {
                $code = Str::lower($orderCode);

                $order = Order::query()->where('code', $code)
                    ->with(['currentCheckpoint.checkpoint'])
                    ->firstOrFail();

                if ($order->currentCheckpoint->checkpoint_type !== (new Hub())->getMorphClass())
                {
                    throw OrderException::OrderIsNotAtHub();
                }
                
                if ($order->is_lost) {
                    throw OrderException::OrderHasBeenLostException();
                }

                $now = Carbon::now();

                $order->is_cancelled = true;
                $order->cancelled_reason = $reason;
                $order->cancelled_at = $now;
                $order->is_lost = true;
                $order->lost_incharge_id = $staffId;
                $order->lost_incharge_type = (new Staff())->getMorphClass();
                $order->save();

                $checkpoint = $order->currentCheckpoint->checkpoint;
                
                OrderCancelled::dispatch(
                    $order,
                    $now->toImmutable(),
                    new LocationData(name: $checkpoint->name, address: $checkpoint->address),
                    $reason
                );
            },
            attempts: 3
        );
    }

}
