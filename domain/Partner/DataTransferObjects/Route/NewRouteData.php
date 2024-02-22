<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Route;
use Domain\CustomerFacing\Enums\PackageType;
use Domain\Partner\DataTransferObjects\RouteSegment\NewRouteMilestoneData;
use Illuminate\Support\Collection;

final readonly class NewRouteData
{
    /**
     * @param Collection<PackageType> $packageTypes
     * @param Collection<NewRouteMilestoneData> $milestones
     */
    public function __construct(
        public int $partnerId,
        public int $startCityCode,
        public int $startDistrictCode,
        public int $endCityCode,
        public int $endDistrictCode,
        public string $name,
        public Collection $packageTypes,
        public Collection $milestones
    ) {
    }
}
