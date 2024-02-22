<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Vehicle;


final readonly class UpdateVehicleData
{
    public function __construct(
        public int $id,
        public string $type,
        public string $plateNumber,
    ) {
    }

    
}
