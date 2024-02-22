<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\OrderRoute;

use Domain\Shared\ValueObjects\Distance;

final readonly class TemporaryRouteCheckpointData
{
    public function __construct(
        public int $id,
        public string $type,
        public int $checkpointNumber,
        public Distance $distanceFromPrevious,
    ) {
    }
}
