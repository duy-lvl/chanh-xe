<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Enums;

enum AccountStatus: int
{
    case Inactive = 0;
    case Active = 1;
}
