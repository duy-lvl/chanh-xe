<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Hub;

use App\Http\Api\Responses\Internal\Profile\ProfileResponse;
use Domain\Internal\DataTransferObjects\Hub\HubData;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

final class HubResource extends JsonApiResource
{
    public function __construct(?HubData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'hub';
    }

    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public function toRelationships(Request $request)
    {
        return [
            'staffs' => fn () => ProfileResponse::collection($this->staffs),
        ];
    }
}
