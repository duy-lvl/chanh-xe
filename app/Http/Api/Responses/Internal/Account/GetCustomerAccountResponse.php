<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Account;

use Domain\Internal\DataTransferObjects\Account\CustomerAccountData;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

final class GetCustomerAccountResponse extends JsonApiResource
{
    public function __construct(CustomerAccountData $resource)
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
            'phone_verified_at' => $this->phoneVerifiedAt,
            'email' => $this->email,
            'email_verified_at' => $this->emailVerifiedAt,
            'status' => $this->status,
            'created_at' => $this->createdAt,
        ];
    }
}
