<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Hub;

final readonly class NewHubData
{
    public function __construct(
        public string $name,
        public ?string $address = null,
        public ?float $latitude = null,
        public ?float $longitude = null,
    ) {
    }
}