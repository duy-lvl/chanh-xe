<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Vehicle\Write\Implementations;

use App\Exceptions\VehicleException;
use App\Models\Vehicle;
use Domain\Partner\Actions\Vehicle\Write\CreateVehicleContract;
use Domain\Partner\DataTransferObjects\Vehicle\NewVehicleData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class CreateVehicle implements CreateVehicleContract
{
    public function handle(NewVehicleData $data): void
    {
        DB::transaction(
            callback: function () use ($data): void {
                $imageUrl = Storage::disk('s3')->putFile('partner_vehicles', $data->image, 'public');
                $deletedVehicle = Vehicle::withTrashed()->where('partner_id', $data->partnerId)
                        ->where('plate_number', $data->plateNumber)->first();
                if ($deletedVehicle !== null) {
                    $deletedVehicle->restore();
                    Storage::disk('s3')->delete($deletedVehicle->image_url);
                    $deletedVehicle->image_url = $imageUrl;
                    $deletedVehicle->save();
                    return;
                }
                
                
                
                $vehicle = Vehicle::query()->create(attributes: 
                    [
                        'plate_number' => $data->plateNumber,
                        'image_url' => $imageUrl,
                        'type' => $data->type,
                        'partner_id' => $data->partnerId
                    ]
                );
                
                if ($vehicle === null) {
                    throw VehicleException::CreateFailException();
                }
            },
            attempts: 3
        );
    }
}
