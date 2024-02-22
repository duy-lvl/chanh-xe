<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Profile;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use Domain\Partner\DataTransferObjects\Profile\ProfileData;

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
        return 'partner';
    }

    public function toAttributes(Request $request): array
    {
        return [
            'username' => $this->username,
            'name' => $this->name,
            'phones' => $this->phones,
            'email' => $this->email,
            'status' => $this->status,
            'avatar' => $this->avatarUrl,
            'description' => $this->description,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'deletedAt' => $this->deletedAt
        ];
    }
}
