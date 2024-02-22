<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Vehicle\Write;

use Illuminate\Http\UploadedFile;

interface UpdateVehicleImageContract
{
    public function handle(int $partnerId, int $vehicleId, UploadedFile $avatar): void;
}
