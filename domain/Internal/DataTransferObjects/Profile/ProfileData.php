<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Profile;

use App\Models\Hub;
use App\Models\Staff;
use DateTimeImmutable;
use Domain\Internal\DataTransferObjects\Hub\HubData;

final readonly class ProfileData
{
    public function __construct(
        public int $id,
        public string $username,
        public ?string $email = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?DateTimeImmutable $deletedAt = null,
        public ?HubData $hub = null,
    ) {
    }

    public static function fromModel(Staff $customer, ?Hub $hub = null): self
    {
        return new self(
            id: $customer->id,
            username: $customer->username,
            email: $customer->email,
            createdAt: $customer->created_at?->toImmutable(),
            updatedAt: $customer->updated_at?->toImmutable(),
            deletedAt: $customer->deleted_at?->toImmutable(),
            hub: null === $hub ? null : HubData::fromModel($hub),
        );
    }
}
