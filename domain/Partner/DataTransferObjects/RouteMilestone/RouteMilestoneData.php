<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\RouteSegment;

use App\Models\RouteMilestone;
use Domain\Partner\DataTransferObjects\Hub\HubData;
use Domain\Partner\DataTransferObjects\Station\StationData;
use Illuminate\Support\Collection;

final readonly class RouteMilestoneData
{
    /** 
     * @param Collection<HubData> $hubs
     */
    public function __construct(
        public int $id,
        public ?StationData $station = null,
        public int $milestoneNumber,
        public float $distanceFromPrevious,
        public ?Collection $hubs = null,
    ) {
    }

    /**
     * @param  Collection<HubData>  $hubs
     */
    public static function fromModel(
        RouteMilestone $model,
        ?StationData $station = null,
        ?Collection $hubs = null,
    ): self {
        return new self(
            id: $model->id,
            station: $station,
            milestoneNumber: (int)$model->milestone_number,
            distanceFromPrevious: (int) $model->distance_from_previous,
            hubs: $hubs,
        );
    }
}
