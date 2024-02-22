<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Order;

use DateTimeImmutable;
use Illuminate\Support\Collection;

final readonly class OrderTrackingData
{
    /**
     * @param  Collection<CheckpointData>  $milestones
     */
    public function __construct(
        public Collection $checkpoints,
        public ?DateTimeImmutable $createdAt = null,
        public bool $isCancelled = false,
        public ?DateTimeImmutable $cancelledAt = null,
        public bool $canBeCancelled = false,
        public ?DateTimeImmutable $confirmedAt = null,
        public ?bool $canBePaid = false
    ) {
    }
}
