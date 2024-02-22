<?php

declare(strict_types=1);

namespace Domain\Partner\Enums;

enum StationStatus: int
{
    case Active = 0;
    case Pending = 1;
    case Deleted = 2;
    case Denied = 3;
    
}
