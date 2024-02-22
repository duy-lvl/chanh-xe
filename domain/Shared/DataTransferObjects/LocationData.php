<?php

declare(strict_types=1);

namespace Domain\Shared\DataTransferObjects;

final readonly class LocationData
{
    public function __construct(
        public string $name,
        public string $address,
    ) {
    }
}
