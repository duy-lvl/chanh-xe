<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Transaction;

use App\Models\Transaction;
use DateTimeImmutable;
final readonly class TransactionData
{
    public function __construct(
        public int $id,
        public int $amount,
        public string $type,
        public string $description,
        public ?string $imageUrl,
        public ?DateTimeImmutable $createdAt = null,
    ) {
    }

    public static function fromModel(Transaction $model, ?string $imageUrl): self
    {
        
        return new self(
            id: $model->id,
            amount: $model->amount,
            type: $model->wallet->type->name,
            description: $model->description,
            createdAt: $model->created_at?->toImmutable(),
            imageUrl: $imageUrl
        );
    }
}
