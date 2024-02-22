<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Auth;

final class NewCustomerData
{
    public function __construct(
        public readonly string $name,
        public readonly string $phone,
        public readonly string $password,
        public readonly ?string $email,
    ) {
    }
}
