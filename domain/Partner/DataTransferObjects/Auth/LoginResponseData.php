<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Auth;

use App\Models\Partner;
use DateTimeImmutable;

final readonly class LoginResponseData
{
    public function __construct(
        public int $id,
        public string $username,
        public string $name,
        public string $accessToken,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    public static function fromModel(Partner $partner, string $accessToken): self
    {
        return new self(
            id: $partner->id,
            username: $partner->username,
            name: $partner->name,
            accessToken: $accessToken,
            createdAt: $partner->created_at?->toImmutable(),
            updatedAt: $partner->updated_at?->toImmutable(),
        );
    }
}
