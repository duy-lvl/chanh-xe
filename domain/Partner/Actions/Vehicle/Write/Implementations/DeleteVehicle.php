<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Vehicle\Write\Implementations;

use App\Exceptions\VehicleException;
use App\Models\Vehicle;
use Domain\Partner\Actions\Vehicle\Write\DeleteVehicleContract;
use Illuminate\Support\Facades\DB;

final class DeleteVehicle implements DeleteVehicleContract
{
    public function handle(int $partnerId, int $vehicleId): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $vehicleId): void {
                $vehicle = Vehicle::findOrFail($vehicleId);
                if ($vehicle->partner_id !== $partnerId) {
                    throw VehicleException::UnauthorizedException();
                }
                $result = $vehicle->delete() > 0;
                if ( ! $result) {
                    throw VehicleException::DeleteFailException();
                }
            },
            attempts: 3
        );
    }
}
