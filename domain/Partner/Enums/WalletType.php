<?php

declare(strict_types=1);

namespace Domain\Partner\Enums;

enum WalletType: int
{
    case Cash = 0;
    case Revenue = 1;
    case CollectionOnBehalf = 2;
}
