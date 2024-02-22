<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Balance;

use Domain\Internal\DataTransferObjects\Balance\TransactionData;
use Domain\Partner\Enums\WalletType;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

final class TransactionResource extends JsonApiResource
{
    public function __construct(TransactionData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'transaction';
    }

    public function toAttributes(Request $request): array {
        $amount = match ($this->type){
            WalletType::CollectionOnBehalf => $this->amount,
            WalletType::Revenue => - $this->amount,
            WalletType::Cash => - $this->amount,
        };

        return [
            'amount' => $amount,
            'type' => $this->type->name,
            'description' => $this->description,
            'created_at' => $this->createdAt,
            'partner_id' => $this->partnerId,
            'partner_name' => $this->partnerName,
        ];
    }
}
