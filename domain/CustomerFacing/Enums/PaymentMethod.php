<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Enums;

enum PaymentMethod: int
{
    case Cash = 0;
    case VnPay = 1;
}
