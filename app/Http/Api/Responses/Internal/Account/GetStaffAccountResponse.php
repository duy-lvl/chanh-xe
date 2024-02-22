<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Account;

use Domain\Internal\DataTransferObjects\Account\StaffAccountData;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

final class GetStaffAccountResponse extends JsonApiResource
{
    public function __construct(StaffAccountData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'staff';
    }

    public function toAttributes(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'hub' => $this->hubData->toArray(),
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
