<?php

declare(strict_types=1);

namespace Domain\Shared\DataTransferObjects;

final readonly class PositionData
{
    public function __construct(
        public float $latitude,
        public float $longitude,
    ) {
    }
}
