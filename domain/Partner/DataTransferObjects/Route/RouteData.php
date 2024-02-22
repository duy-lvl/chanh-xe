<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Route;

// use Domain\Partner\DataTransferObjects\Profile\ProfileData as PartnerData;

use App\Models\Route;
use Domain\Partner\DataTransferObjects\RouteSegment\RouteMilestoneData;
use Illuminate\Support\Collection;

final readonly class RouteData
{
    /**
     * @param Collection<\Domain\CustomerFacing\Enums\PackageType> $packageTypes
     * @param null|Collection<RouteMilestoneData> $routeSegments
     */
    public function __construct(
        public int $id,
        public int $startCityCode,
        public int $startDistrictCode,
        public int $endCityCode,
        public int $endDistrictCode,
        public string $name,
        public Collection $packageTypes,
        public ?Collection $milestones = null,
    ) {
    }

    /**
     * @param  Collection<RouteMilestoneData>  $routeSegments
     */
    public static function fromModel(Route $model, ?Collection $milestones = null): self
    {
        return new self(
            id: $model->id,
            startCityCode: $model->start_city_code,
            startDistrictCode: $model->start_district_code,
            endCityCode: $model->end_city_code,
            endDistrictCode: $model->end_district_code,
            name: $model->name,
            packageTypes: $model->package_types,
            milestones: $milestones,
        );
    }
}
