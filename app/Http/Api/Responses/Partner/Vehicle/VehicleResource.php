<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Vehicle;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use Domain\Partner\DataTransferObjects\Vehicle\VehicleData;

final class VehicleResource extends JsonApiResource
{
    public function __construct(VehicleData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'vehicle';
    }

    public function toAttributes(Request $request): array {
        return [
            'type' => $this->type,
            'plate_number' => $this->plateNumber,
            'image_url' => $this->imageUrl,
        ];
    }
}
