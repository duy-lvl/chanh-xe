<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Auth;

use DateTime;

final class UserData
{
    public function __construct(
        public readonly string|int $id, //TODO: finalize uuid or int
        public readonly string $name,
        public readonly string $email,
        public readonly string $passwordHash,
        public readonly ?DateTime $emailVerifiedAt,
    ) {
    }
}
