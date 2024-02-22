<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Enums;

enum PaymentStatus: int
{
    case NotPaid = 0;
    case Paid = 1;

}
