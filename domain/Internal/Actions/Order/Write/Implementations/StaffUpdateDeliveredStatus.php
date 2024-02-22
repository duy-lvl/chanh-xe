<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Order\Write\Implementations;

use App\Events\OrderDelivered;
use App\Exceptions\OrderException;
use App\Models\Hub;
use App\Models\Order;
use App\Models\Partner;
use App\Models\Staff;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\Internal\Actions\Order\Write\StaffUpdateDeliveredStatusContract;
use Domain\Internal\Enums\StaffRole;
use Domain\Shared\DataTransferObjects\LocationData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Str;

final class StaffUpdateDeliveredStatus implements StaffUpdateDeliveredStatusContract
{
    public function handle(int $staffId, string $orderCode): void
    {
        DB::transaction(
            callback: function () use ($staffId, $orderCode): void {
                $code = Str::lower($orderCode);

                $staff = Staff::query()->findOrFail($staffId);

                //check if order belongs to staff
                if (null === $staff->hub_id && ! $staff->hasRole(StaffRole::Manager, 'api_internal')) {
                    throw OrderException::OrderNotBelongToStaffException();
                }

                $order = Order::query()
                    ->where('code', $code)
                    ->whereRelation('routeCheckpoints', 'checkpoint_type', (new Hub())->getMorphClass())
                    ->when(( ! $staff->hasRole(StaffRole::Manager, 'api_internal')), fn ($query) => $query->whereRelation('routeCheckpoints', 'checkpoint_id', '=', $staff->hub_id))
                    ->with(['routeCheckpoints.checkpoint', 'routeCheckpoints.permissions', 'currentCheckpoint.permissions', 'nextCheckpoint.permissions'])
                    ->firstOrFail();

                //the current status must be Delivering and Authored by partner

                if ( ! (0 === $order->currentCheckpoint->permissions->where('achieved_at', null)->count())
                    && $order->nextCheckpoint->permissions->where('achieved_at', '<>', null)->count() > 0) {
                    throw OrderException::InvalidOrderStatusException();
                }

                $now = Carbon::now();

                $updateResult = $order->nextCheckpoint->permissions()
                    ->where('permission', OrderStatus::Delivered)
                    ->update(['achieved_at' => $now]);

                if (0 === $updateResult) {
                    throw OrderException::UpdateStatusFailedException();
                }

                $order->load('previousCheckpoint.checkpoint.partner');

                OrderDelivered::dispatch(
                    $order,
                    $now->toImmutable(),
                    new LocationData(name: $order->startStation->name, address: $order->startStation->address),
                    $order->previousCheckpoint?->checkpoint_number,
                    $order->previousCheckpoint?->checkpoint?->partner_id,
                );
            },
            attempts: 3
        );
    }
}
