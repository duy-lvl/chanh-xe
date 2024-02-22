<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\OrderRoute;

use Domain\CustomerFacing\Enums\PackageType;
use Domain\Shared\ValueObjects\Distance;
use Illuminate\Support\Collection;

final readonly class SearchedOrderRouteData
{
    /**
     * @param  Collection<PackageType>  $acceptablePackageTypes
     */
    public function __construct(
        public int $id,
        public StationData $startStation,
        public StationData $endStation,
        public int $lowestPrice,
        public Distance $totalDistance,
        public ?string $note = null,
        public Collection $acceptablePackageTypes,
    ) {
    }

    public function cloneWithNote(string $note): self
    {
        return new self(
            id: $this->id,
            startStation: $this->startStation,
            endStation: $this->endStation,
            lowestPrice: $this->lowestPrice,
            totalDistance: $this->totalDistance,
            note: $note,
            acceptablePackageTypes: $this->acceptablePackageTypes,
        );
    }
}
