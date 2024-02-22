<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Vehicle\Write;

use Domain\Partner\DataTransferObjects\Vehicle\NewVehicleData;

interface CreateVehicleContract
{
    public function handle(NewVehicleData $data): void;
}
