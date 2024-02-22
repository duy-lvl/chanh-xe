<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\OrderRoute;

use Domain\Shared\ValueObjects\Distance;

final readonly class StationData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $address,
        public string $cityCode,
        public Distance $distanceToUser,
        public int $partnerId,
        public string $partnerName,
        public ?string $imageUrl,
        public float $latitude,
        public float $longitude
    ) {
    }
}
