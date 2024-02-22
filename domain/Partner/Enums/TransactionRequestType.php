<?php

declare(strict_types=1);

namespace Domain\Partner\Enums;

enum TransactionRequestType: int
{
    case Withdraw = 0;
    case Topup = 1;    
}
