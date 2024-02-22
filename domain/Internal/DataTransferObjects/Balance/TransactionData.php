<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Balance;

use App\Models\Partner;
use App\Models\Transaction;
use DateTimeImmutable;
use Domain\Internal\DataTransferObjects\Account\PartnerAccountData;
use Domain\Partner\Enums\WalletType;

final readonly class TransactionData
{
    public function __construct(
        public int $id,
        public int $amount,
        public WalletType $type,
        public ?string $description = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?int $partnerId = null,
        public ?string $partnerName = null,
    ) {
    }

    public static function fromModel(Transaction $model, Partner $partner): self
    {
        return new self(
            id: $model->id,
            amount: $model->amount,
            type: $model->wallet->type,
            description: $model->description,
            createdAt: $model->created_at?->toImmutable(),
            partnerId: $partner->id,
            partnerName: $partner->name,
        );
    }
}
