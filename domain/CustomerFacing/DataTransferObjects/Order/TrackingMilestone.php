<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Order;

use DateTimeImmutable;
use Domain\CustomerFacing\Enums\OrderStatus;

final class TrackingMilestone
{
    public function __construct(
        public OrderStatus $type,
        public ?DateTimeImmutable $achievedAt = null,
        public ?string $location = null,
        public ?string $address = null,
    ) {
    }
}
