<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Account;

use App\Models\Customer;
use DateTimeImmutable;
use Domain\Shared\Enums\AccountStatus;

final readonly class CustomerAccountData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $phone,
        public ?DateTimeImmutable $phoneVerifiedAt = null,
        public string $email,
        public ?DateTimeImmutable $emailVerifiedAt = null,
        public AccountStatus $status,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?string $deletedAt = null,
    ) {
    }

    public static function fromModel(Customer $model): self {
        return new self (
            id: $model->id,
            name: $model->name,
            email: $model->email,
            emailVerifiedAt: $model->email_verified_at?->toImmutable(),
            phone: $model->phone,
            phoneVerifiedAt: $model->phone_verified_at?->toImmutable(),
            status: $model->status,
            createdAt: $model->created_at?->toImmutable(),
            updatedAt: $model->updated_at?->toImmutable(),
            deletedAt: $model->deleted_at??null
        );
    }
}
