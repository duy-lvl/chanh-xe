<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Transaction;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use Domain\Partner\DataTransferObjects\Transaction\TransactionRequestData;

final class GetTransactionRequestResource extends JsonApiResource
{
    public function __construct(TransactionRequestData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'transaction_request';
    }

    public function toAttributes(Request $request): array {
        return [
            'type' => $this->type->name,
            'amount' => (int) $this->amount,
            'created_at' => $this->createdAt,
            'is_proceeded' => $this->isProceeded,
            'image_url' => $this->imageUrl
        ];
    }
}
