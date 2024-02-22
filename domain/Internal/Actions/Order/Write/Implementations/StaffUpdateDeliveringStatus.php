<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Order\Write\Implementations;

use App\Events\OrderDelivering;
use App\Exceptions\OrderException;
use App\Models\Driver;
use App\Models\Hub;
use App\Models\Order;
use App\Models\Staff;
use App\Models\Vehicle;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\Internal\Actions\Order\Write\StaffUpdateDeliveringStatusContract;
use Domain\Internal\Enums\StaffRole;
use Domain\Shared\DataTransferObjects\LocationData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Str;

final class StaffUpdateDeliveringStatus implements StaffUpdateDeliveringStatusContract
{
    public function handle(int $staffId, string $orderCode, int $driverId, int $vehicleId): void
    {

        DB::transaction(
            callback: function () use ($staffId, $orderCode, $driverId, $vehicleId): void {
                $code = Str::lower($orderCode);

                $staff = Staff::query()->with('hub')->findOrFail($staffId);

                if (null === $staff->hub_id && ! $staff->hasRole(StaffRole::Manager, 'api_internal')) {
                    throw OrderException::OrderNotBelongToStaffException();
                }

                $order = Order::query()
                    ->where('code', $code)
                    ->whereRelation('routeCheckpoints', 'checkpoint_type', (new Hub())->getMorphClass())
                    ->when(( ! $staff->hasRole(StaffRole::Manager, 'api_internal')), fn ($query) => $query->whereRelation('routeCheckpoints', 'checkpoint_id', '=', $staff->hub_id))
                    ->with(['routeCheckpoints.checkpoint', 'routeCheckpoints.permissions'])
                    ->firstOrFail();

                //the current status must be Delivered and Authored by hub (not partner(s))
                if (0 === $order->currentCheckpoint->permissions->where('achieved_at', null)->count()) {
                    throw OrderException::InvalidOrderStatusException();
                }

                $now = Carbon::now();

                $lastCheckpoint = $order->lastCheckpoint->loadMissing('checkpoint');
                
                $vehicle = Vehicle::query()->findOrFail($vehicleId);
                if ($lastCheckpoint->checkpoint->partner_id !== $vehicle->partner_id) {
                    throw OrderException::VehicleNotBelongToPartner();
                }

                $driver = Driver::query()->findOrFail($driverId);
                if ($lastCheckpoint->checkpoint->partner_id !== $driver->partner_id) {
                    throw OrderException::DriverNotBelongToPartner();
                }
                $nextCheckpoint = $order->nextCheckpoint;
                $nextCheckpoint->driver_id = $driverId;
                $nextCheckpoint->vehicle_id = $vehicleId;

                $nextCheckpoint->save();                

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
