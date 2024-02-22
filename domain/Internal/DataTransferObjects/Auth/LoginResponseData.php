<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Auth;

use App\Models\Staff;
use DateTimeImmutable;

final readonly class LoginResponseData
{
    public function __construct(
        public int $id,
        public string $username,
        public ?string $email,
        public ?string $hubName,
        public string $accessToken,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    public static function fromModel(Staff $staff, string $accessToken): self
    {
        $hubName = $staff->loadMissing('hub')->hub?->name;
        return new self(
            id: $staff->id,
            username: $staff->username,
            email: $staff->email,
            hubName: $hubName,
            accessToken: $accessToken,
            createdAt: $staff->created_at?->toImmutable(),
            updatedAt: $staff->updated_at?->toImmutable(),
        );
    }
}
