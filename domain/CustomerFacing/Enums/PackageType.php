<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Enums;

enum PackageType: int
{
    case Normal = 0;
    case Food = 1;
    case Chemical = 2; // hoa chat
    case Document = 3; // giay to
    case Electronic = 4; // dien tu
    case Fragile = 5; //de vo
}
