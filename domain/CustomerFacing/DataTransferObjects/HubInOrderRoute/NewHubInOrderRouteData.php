<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\OrderRoute;

final class NewHubInOrderRouteData
{
    public function __construct(
        public int $startStationId,
        public string $endStationId,
        public int $orderId,
        public bool $isSelected,
        // public Collection
    ) {
    }
}