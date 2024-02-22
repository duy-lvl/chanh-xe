<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Auth;

final readonly class LoginData
{
    public function __construct(
        public string $indentifier,
        public string $password,
        public ?string $deviceName = null,
    ) {
    }
}
