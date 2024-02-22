<?php

declare(strict_types=1);

namespace Domain\Auth\DataTransferObjects;

final class NewUserData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    ) {
    }
}
