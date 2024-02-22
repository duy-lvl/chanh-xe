<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Account;

use Domain\Internal\DataTransferObjects\Account\PartnerAccountData;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

final class GetPartnerAccountResponse extends JsonApiResource
{
    public function __construct(PartnerAccountData $resource)
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
            'id' => $this->id,
            'name' => $this->name,
            'phones' => $this->phones,
            'created_at' => $this->createdAt,
            'status' => $this->status,
        ];
    }
}
