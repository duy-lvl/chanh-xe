<?php

declare(strict_types=1);

namespace Domain\Internal\Enums;

enum StaffRole: string
{
    case Manager = 'manager';
    case Personnel = 'personnel';
}
