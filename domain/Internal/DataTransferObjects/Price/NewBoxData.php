<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Price;

use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Weight;

final readonly class NewBoxData
{
    public function __construct(
        public Dimensions $dimensions,
        public Weight $weight
    ) {
    }
}
