<?php

declare(strict_types=1);

namespace Domain\Internal\Enums;

enum PriceTableStatus: int
{
    case Unavailable = 0;
    case Available = 1;

}
