<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Price\Read;

use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Distance;
use Domain\Shared\ValueObjects\Weight;

interface GetPackagePriceContract
{
    public function handle(Weight $weight, Dimensions $dimensions, Distance $distance): int;
}
