<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Partner;

use Domain\CustomerFacing\DataTransferObjects\Partner\PartnerData;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

final class PartnerResource extends JsonApiResource
{
    public function __construct(PartnerData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'partner';
    }

    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'avatar_url' => $this->avatarUrl,
            'created_at' => $this->createdAt
        ];
    }
}
