<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Account;

use App\Models\Partner;
use DateTimeImmutable;
use Domain\Shared\Enums\AccountStatus;
use Illuminate\Support\Collection;
use SensitiveParameter;

final readonly class PartnerAccountData
{
    /** @param  ?Collection<string>  $phones*/
    public function __construct(
        public int $id,
        public string $name,
        public string $username,
        #[SensitiveParameter]
        public ?string $password = null,
        public string $bankAccountNumber,
        public string $bankAccountName,
        public string $bankCode,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        public ?Collection $phones = null,
        public AccountStatus $status
    ) {
    }

    /**
     * @param  Collection<string>  $phones
     */
    public static function fromModel(Partner $partner, ?Collection $phones = null): self
    {
        return new self(
            id: $partner->id,
            name: $partner->name,
            username: $partner->username,
            password: null,
            createdAt: $partner->created_at->toImmutable(),
            updatedAt: $partner->updated_at->toImmutable(),
            phones: $phones,
            bankCode: $partner->bank_code,
            bankAccountName: $partner->bank_account_name,
            bankAccountNumber: $partner->bank_account_number,
            status: $partner->status
        );
    }
}
