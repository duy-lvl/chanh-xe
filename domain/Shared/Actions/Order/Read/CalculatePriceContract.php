<?php

declare(strict_types=1);

namespace Domain\Shared\Actions\Order\Read;

use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Distance;
use Domain\Shared\ValueObjects\Weight;

interface CalculatePriceContract
{
    public function handle(Weight $weight, Dimensions $dimensions, Distance $distance): int;
}
