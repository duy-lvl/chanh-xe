<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Write\Implementations;

use App\Events\OrderDelivering;
use App\Exceptions\OrderException;
use App\Models\Order;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\Partner\Actions\Order\Write\UpdateDeliveringStatusContract;
use Domain\Shared\DataTransferObjects\LocationData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class UpdateDeliveringStatus implements UpdateDeliveringStatusContract
{
    public function handle(int $partnerId, string $orderCode, int $vehicleId, int $driverId): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $orderCode, $driverId, $vehicleId): void {
                $code = Str::lower($orderCode);

                $order = Order::query()
                    ->with(['nextCheckpoint', 'startStation', 'currentCheckpoint.checkpoint', 'currentCheckpoint.permissions'])
                    ->where('code', $code)->firstOrFail();

                if ($order->startStation->partner_id !== $partnerId) {
                    throw OrderException::OrderNotBelongToPartnerException();
                }
                
                $permissions = $order->currentCheckpoint->permissions;

                if ( ! (null !== $permissions->where('permission', OrderStatus::Accepted)->first()?->achieved_at
                    && null === $permissions->where('permission', OrderStatus::Delivering)->first()?->achieved_at)) {
                    throw OrderException::InvalidOrderStatusException();
                }

                $now = Carbon::now();

                $checkpoint = $order->nextCheckpoint;

                $checkpoint->driver_id = $driverId;
                $checkpoint->vehicle_id = $vehicleId;

                $checkpoint->save();

                $updateResult = $order->currentCheckpoint->permissions()
                    ->where('permission', OrderStatus::Delivering)
                    ->update(['achieved_at' => $now]);

                if (0 === $updateResult) {
                    throw OrderException::UpdateStatusFailedException();
                }

                OrderDelivering::dispatch(
                    $order,
                    $now->toImmutable(),
                    new LocationData(name: $order->startStation->name, address: $order->startStation->address),
                );

                
            },
            attempts: 3
        );
    }
}
