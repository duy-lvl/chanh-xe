<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Read;

use Domain\CustomerFacing\Enums\PackageType;
use Domain\Shared\DataTransferObjects\PositionCodeData;
use Domain\Shared\DataTransferObjects\PositionData;
use Domain\Shared\ValueObjects\Distance;
use Illuminate\Support\Collection;

interface SearchRouteContract
{
    /**
     * @param  Collection<PackageType>  $packageTypes
     */
    public function handle(
        ?PositionData $startPosition,
        ?PositionCodeData $startPositionCode,
        Distance $maxDistanceToStart,
        ?PositionData $endPosition,
        ?PositionCodeData $endPositionCode,
        Distance $maxDistanceToEnd,
        Collection $packageTypes,
        int $numberOfResults
    );
}
