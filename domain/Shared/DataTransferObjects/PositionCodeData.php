<?php

declare(strict_types=1);

namespace Domain\Shared\DataTransferObjects;

final readonly class PositionCodeData
{
    public function __construct(
        public string $cityCode,
        public string $districtCode,
    ) {
    }
}
