<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\RouteSegment;

use Illuminate\Support\Collection;

final readonly class NewRouteMilestoneData
{
    /**
     * @param Collection<array<int, array<string,int>>> $hubIds
     */
    public function __construct(
        public int $stationId,
        public int $milestoneNumber,
        public float $distanceFromPrevious,
        public Collection $hubs,
    ) {
    }
}
