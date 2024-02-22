<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\OrderRoute;

use Domain\CustomerFacing\Enums\PackageType;
use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\ValueObjects\Distance;
use Illuminate\Support\Collection;

final readonly class TemporaryRouteData
{
    public Distance $totalDistance;

    /**
     * @param  Collection<TemporaryRouteCheckpointData>  $checkpoints,
     * @param  Collection<PackageType>  $acceptablePackageTypes
     */
    public function __construct(
        public Collection $checkpoints,
        public Collection $acceptablePackageTypes,
    ) {
        $this->totalDistance = new Distance(
            value: $checkpoints->sum(fn (TemporaryRouteCheckpointData $checkpoint) => $checkpoint->distanceFromPrevious->value()),
            unit: LengthUnit::Meter,
        );
    }
}
