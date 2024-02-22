<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Write\Implementations;

use App\Events\OrderDelivered;
use App\Exceptions\OrderException;
use App\Models\Hub;
use App\Models\Order;
use App\Models\Station;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\Partner\Actions\Order\Write\UpdateDeliveredStatusContract;
use Domain\Shared\DataTransferObjects\LocationData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class UpdateDeliveredStatus implements UpdateDeliveredStatusContract
{
    public function handle(int $partnerId, string $orderCode): bool
    {
        return DB::transaction(
            callback: function () use ($partnerId, $orderCode): bool {
                $code = Str::lower($orderCode);

                $order = Order::query()->with(['nextCheckpoint.checkpoint', 'endStation', 'routeCheckpoints', 'currentCheckpoint.checkpoint'])
                    ->where('code', $code)->firstOrFail();

                $passThroughHubFlag = $order->routeCheckpoints()->where('checkpoint_type', (new Hub())->getMorphClass())->count() > 0;

                if ($order->currentCheckpoint->checkpoint_type !== (($passThroughHubFlag) ? new Hub() : new Station())->getMorphClass()) {
                    throw OrderException::InvalidOrderStatusException();
                }

                // order done
                if ($order->nextCheckpoint === null) {
                    throw OrderException::InvalidOrderStatusException();
                }

                if ($order->nextCheckpoint->checkpoint->partner_id !== $partnerId) {
                    throw OrderException::OrderNotBelongToPartnerException();
                }

                $now = Carbon::now();

                $updateResult = $order->nextCheckpoint->permissions()
                    ->where('permission', OrderStatus::Delivered)
                    ->update(['achieved_at' => $now]);

                if (0 === $updateResult) {
                    throw OrderException::UpdateStatusFailedException();
                }

                OrderDelivered::dispatch(
                    $order,
                    $now->toImmutable(),
                    new LocationData(name: $order->endStation->name, address: $order->endStation->address),
                    (int) $order->currentCheckpoint->checkpoint_number,
                    $partnerId,
                );

                return true;
            },
            attempts: 3
        );
    }
}
