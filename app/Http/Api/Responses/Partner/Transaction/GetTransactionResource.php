<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Transaction;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use Domain\Partner\DataTransferObjects\Transaction\TransactionData;

final class GetTransactionResource extends JsonApiResource
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
        return [
            'type' => $this->type,
            'amount' => (int) $this->amount,
            'description' => $this->description,
            'created_at' => $this->createdAt
        ];
    }
}
