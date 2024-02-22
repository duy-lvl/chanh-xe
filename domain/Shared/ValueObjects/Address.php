<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObjects;

final class Address
{
    public function __construct(
        public readonly ?string $city = null,
        public readonly ?string $district = null,
        public readonly ?string $ward = null,
        public readonly ?string $street = null,
        public readonly ?float $latitude = null,
        public readonly ?float $longitude = null,
    ) {
    }
}
