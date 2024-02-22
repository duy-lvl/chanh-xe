<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Profile;

use App\Models\Customer;
use DateTimeImmutable;
use Domain\Shared\Enums\AccountStatus;

final readonly class ProfileData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $phone,
        public ?string $email = null,
        public AccountStatus $status,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?DateTimeImmutable $deletedAt = null,
    ) {
    }

    public static function fromModel(Customer $customer): self
    {
        return new self(
            id: $customer->id,
            name: $customer->name,
            phone: $customer->phone,
            email: $customer->email,
            status: $customer->status,
            createdAt: $customer->created_at?->toImmutable(),
            updatedAt: $customer->updated_at?->toImmutable(),
            deletedAt: $customer->deleted_at?->toImmutable(),
        );
    }
}
