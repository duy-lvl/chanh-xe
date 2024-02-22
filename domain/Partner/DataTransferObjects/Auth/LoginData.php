<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Auth;

final readonly class LoginData
{
    public function __construct(
        public string $username,
        public string $password,
        public ?string $deviceName = null,
    ) {
    }
}
