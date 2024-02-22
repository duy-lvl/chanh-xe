<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Vehicle\Write\Implementations;

use App\Exceptions\VehicleException;
use App\Models\Vehicle;
use Domain\Partner\Actions\Vehicle\Write\UpdateVehicleContract;
use Domain\Partner\DataTransferObjects\Vehicle\UpdateVehicleData;
use Illuminate\Support\Facades\DB;

final class UpdateVehicle implements UpdateVehicleContract
{
    public function handle(int $partnerId, UpdateVehicleData $data): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $data): void {
                $vehicle = Vehicle::findOrFail($data->id);
                if ($vehicle->partner_id !== $partnerId) {
                    throw VehicleException::UnauthorizedException();
                }
                $vehicle->type = $data->type;
                $vehicle->plate_number = $data->plateNumber;
                $updateResult = $vehicle->save();
                if ( ! $updateResult) {
                    throw VehicleException::UpdateFailException();
                }
            },
            attempts: 3
        );
    }
}
