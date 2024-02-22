<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Vehicle\Write\Implementations;

use App\Exceptions\VehicleException;
use App\Models\Partner;
use App\Models\Vehicle;
use Domain\Partner\Actions\Vehicle\Write\UpdateVehicleImageContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class UpdateVehicleImage implements UpdateVehicleImageContract
{
    public function handle(int $partnerId, int $vehicleId, UploadedFile $image): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $vehicleId, $image): void {
                $vehicle = Vehicle::query()->findOrFail($vehicleId);

                if ($partnerId !== $vehicle->partner_id) {
                    throw VehicleException::UnauthorizedException();
                }

                if ($vehicle->image_url !== null && Storage::disk('s3')->exists($vehicle->image_url)) {
                    Storage::disk('s3')->delete($vehicle->image_url);
                }

                $imageUrl = Storage::disk('s3')->putFile('partner_vehicles', $image, 'public');

                $vehicle->image_url = $imageUrl;
                $updateResult = $vehicle->save();

                if ( ! $updateResult) {
                    throw VehicleException::UpdateFailException();
                }
            },
            attempts: 3
        );
    }
}
