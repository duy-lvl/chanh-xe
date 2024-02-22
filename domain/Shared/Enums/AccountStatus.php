<?php

declare(strict_types=1);

namespace Domain\Shared\Enums;

enum AccountStatus: int
{
    case Inactive = 0;
    case Active = 1;
}
