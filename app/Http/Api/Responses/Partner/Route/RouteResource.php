<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Route;

use Domain\Partner\DataTransferObjects\Route\RouteData;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

final class RouteResource extends JsonApiResource
{
    public function __construct(RouteData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'route';
    }

    public function toAttributes(Request $request): array
    {

        return [
            'name' => $this->name,
            'start_city_code' => $this->startCityCode,
            'start_district_code' => $this->startDistrictCode,
            'end_city_code' => $this->endCityCode,
            'end_district_code' => $this->endDistrictCode,
            'package_types' => $this->packageTypes,
            'milestones' => MilestoneResource::collection($this->milestones),
        ];
    }
    // public function toRelationships(Request $request): array {
    //     return [
    //         'segments' => fn() => SegmentResource::collection($this->routeSegments)
    //     ];
    // }
}
