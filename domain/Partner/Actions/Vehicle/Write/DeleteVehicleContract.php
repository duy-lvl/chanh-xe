<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Vehicle\Write;

interface DeleteVehicleContract
{
    public function handle(int $partnerId, int $vehicleId): void;
}
