<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Account;

final readonly class NewStaffAccountData
{
    public function __construct(
        public string $email,
        public string $username,
        public ?int $hubId = null,
    ) {
    }
}
