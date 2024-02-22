<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Transaction;

use Domain\Internal\DataTransferObjects\Transaction\TransactionRequestData;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

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
            'partner_id' => $this->partner->id,
            'partner_name' => $this->partner->name,
            'type' => $this->type->name,
            'amount' => (int) $this->amount,
            'created_at' => $this->createdAt,
            'bank_account_number' => $this->partner->bankAccountNumber,
            'bank_account_name' => $this->partner->bankAccountName,
            'bank_code' => $this->partner->bankCode,
            'is_proceeded' => $this->isProceeded,
            'image_url' => $this->imageUrl
        ];
    }
}
