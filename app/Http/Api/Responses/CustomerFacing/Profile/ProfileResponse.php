<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Profile;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use Domain\CustomerFacing\DataTransferObjects\Profile\ProfileData;

final class ProfileResponse extends JsonApiResource
{
    public function __construct(ProfileData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'customer';
    }

    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
