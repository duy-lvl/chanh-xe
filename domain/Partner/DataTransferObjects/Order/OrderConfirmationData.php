<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Order;

use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Weight;

final class OrderConfirmationData
{
    public function __construct(
        public string $code,
        public Weight $packageWeight,
        public Dimensions $packageDimensions,
        public int $packageValue
    ) {
    }
}
