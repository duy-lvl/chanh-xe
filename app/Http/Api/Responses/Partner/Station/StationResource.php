<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Station;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use Domain\Partner\DataTransferObjects\Station\StationData;

final class StationResource extends JsonApiResource
{
    public function __construct(StationData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'station';
    }

    public function toAttributes(Request $request): array {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => $this->status,
            'city_code' => $this->cityCode,
            'district_code' => $this->districtCode,
            'avatar_url' => $this->avatarUrl ?? null
        ];
    }
}
