<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Vehicle;

use Illuminate\Http\UploadedFile;

final readonly class NewVehicleData
{
    public function __construct(
        public string $type,
        public UploadedFile $image,
        public string $plateNumber,
        public int $partnerId 
    ) {
    }

    
}
