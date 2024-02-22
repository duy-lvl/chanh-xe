<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Route;

use Domain\Partner\DataTransferObjects\RouteSegment\RouteMilestoneData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class MilestoneResource extends JsonResource
{
    public function __construct(RouteMilestoneData $resource)
    {
        $this->resource = $resource;
    }

    // public function toId(Request $request): string
    // {
    //     return (string) $this->id;
    // }

    // public function toType(Request $request): string
    // {
    //     return 'route_segment';
    // }

    public function toArray(Request $request): array
    {
        return [
            'station' => $this->station->toArray(),
            'milestone_number' => $this->milestoneNumber,
            'distance_from_previous' => $this->distanceFromPrevious,
            'hubs' => $this->hubs,
        ];
    }

    // public function toRelationships(Request $request): array
    // {
    //     return [
    //         'start_station' => new GetStationResource($this->startStation),
    //         'end_station' => new GetStationResource($this->endStation),
    //         'hubs' => GetHubResource::collection($this->hubs)
    //     ];
    // }
}
