<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Profile;

use App\Http\Api\Responses\Internal\Hub\HubResource;
use Domain\Internal\DataTransferObjects\Profile\ProfileData;
use Domain\Internal\Enums\StaffRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TiMacDonald\JsonApi\JsonApiResource;

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
        return Auth::user()->hasRole(StaffRole::Manager, 'api_internal') ? 'admin' : 'staff';
    }

    public function toAttributes(Request $request): array
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }

    public function toRelationships(Request $request)
    {
        return [
            'hub' => fn () => HubResource::make($this->hub),
        ];
    }
}
