<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Station;

use Domain\Partner\Enums\StationStatus;

final readonly class NewStationData
{
    public function __construct(
        public int $partnerId,
        public string $name,
        public ?string $address = null,
        public ?float $latitude = null,
        public ?float $longitude = null,
        public int $cityCode,
        public int $districtCode,
        public ?int $wardCode = null,
        
        public StationStatus $status,
    ) {
    }

    
}
