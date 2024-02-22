<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Transaction;

use App\Models\TransactionRequest;
use DateTimeImmutable;
use Domain\Internal\DataTransferObjects\Account\PartnerAccountData;
use Domain\Partner\Enums\TransactionRequestType;

final readonly class TransactionRequestData
{
    public function __construct(
        public int $id,
        public PartnerAccountData $partner,
        public int $amount,
        public TransactionRequestType $type,
        public bool $isProceeded,
        public ?string $imageUrl,
        public ?DateTimeImmutable $createdAt = null,
    ) {
    }

    public static function fromModel(
        TransactionRequest $model, 
        PartnerAccountData $partner, 
        bool $isProceeded,
        ?string $imageUrl
    ): self
    {
        return new self(
            id: $model->id,
            partner: $partner,
            type: $model->type,
            amount: (int) $model->amount,
            isProceeded: $isProceeded,
            imageUrl: $imageUrl,
            createdAt: $model->created_at?->toImmutable(),
        );
    }
}
