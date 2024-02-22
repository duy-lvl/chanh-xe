<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Account;

use App\Models\Staff;
use DateTimeImmutable;
use Domain\Internal\DataTransferObjects\Hub\HubData;
use Domain\Shared\Enums\AccountStatus;
use SensitiveParameter;

final readonly class StaffAccountData
{
    public function __construct(
        public int $id,
        public string $email,
        public string $username,
        #[SensitiveParameter]
        public ?string $password = null,
        public ?int $hubId = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?HubData $hubData = null,
        public AccountStatus $status
    ) {
    }

    public static function fromModel(Staff $model, HubData $hubData): self
    {
        return new self(
            id: $model->id,
            email: $model->email,
            username: $model->username,
            password: null,
            hubId: $model->hub_id,
            createdAt: $model->created_at->toImmutable(),
            updatedAt: $model->updated_at->toImmutable(),
            hubData: $hubData,
            status: $model->status
        );
    }
}
