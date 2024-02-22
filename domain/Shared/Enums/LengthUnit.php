<?php

declare(strict_types=1);

namespace Domain\Shared\Enums;

enum LengthUnit: string
{
    case Milimeter = 'mm';
    case Centimeter = 'cm';
    case Decimeter = 'dm';
    case Meter = 'm';
    case Kilometer = 'km';

}
