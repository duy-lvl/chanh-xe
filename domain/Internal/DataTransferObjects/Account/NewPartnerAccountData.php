<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Account;

use Illuminate\Support\Collection;

final readonly class NewPartnerAccountData
{
    /**
     * @param Collection<string> $phones
     */
    public function __construct(
        public string $name,
        public string $username,
        public string $bankAccountName,
        public string $bankCode,
        public string $bankAccountNumber,
        public ?Collection $phones = null
    ) {
    }
}
