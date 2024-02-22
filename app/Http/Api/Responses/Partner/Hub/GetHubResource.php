<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Hub;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use Domain\Partner\DataTransferObjects\Hub\HubData;

final class GetHubResource extends JsonApiResource
{
    public function __construct(HubData $resource)
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

    public function toAttributes(Request $request): array {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
