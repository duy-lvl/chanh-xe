<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Vehicle\Write;

use Domain\Partner\DataTransferObjects\Vehicle\UpdateVehicleData;

interface UpdateVehicleContract
{
    public function handle(int $partnerId, UpdateVehicleData $data): void;
}
