<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Driver;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use Domain\Partner\DataTransferObjects\Driver\DriverData;

final class DriverResource extends JsonApiResource
{
    public function __construct(DriverData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'driver';
    }

    public function toAttributes(Request $request): array {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'avatar_url' => $this->avatarUrl,
        ];
    }
}
