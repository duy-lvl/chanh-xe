<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Profile;

use App\Models\Partner;
use DateTimeImmutable;
use Domain\Shared\Enums\AccountStatus;
use Illuminate\Support\Collection;
use Facades\Domain\Shared\Services\Image;

final readonly class ProfileData
{
    public function __construct(
        public int $id,
        public string $username,
        public string $name,
        /** @var Collection<string> $phones */
        public Collection $phones,
        public ?string $email = null,
        public ?string $avatarUrl = null,
        public AccountStatus $status,
        public ?string $description = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?DateTimeImmutable $deletedAt = null,
    ) {
    }

    /**
     * @param  null|Collection<string>  $phones
     */
    public static function fromModel(Partner $partner, ?Collection $phones = null): self
    {
        $avatarUrl = Image::getFileTemporaryUrl($partner->avatar_url);
     
        return new self(
            id: $partner->id,
            username: $partner->username,
            name: $partner->name,
            phones: $phones,
            email: $partner->email,
            status: $partner->status,
            createdAt: $partner->created_at?->toImmutable(),
            updatedAt: $partner->updated_at?->toImmutable(),
            deletedAt: $partner->deleted_at?->toImmutable(),
            avatarUrl: $avatarUrl,
            description: $partner->description
        );
    }
}
