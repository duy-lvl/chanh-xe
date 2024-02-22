<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObjects;

use Domain\Shared\Enums\LengthUnit;

final class Distance
{
    private readonly int $valueInMeter;

    /**
     * @param  int  $value can only be int, even in larger units.
     */
    public function __construct(int $value, LengthUnit $unit = LengthUnit::Meter)
    {
        $multiplier = $this->getMultiplier($unit);

        $this->valueInMeter = $value * $multiplier;
    }

    public function value(): int
    {
        return $this->valueInMeter;
    }

    public function convertValue(LengthUnit $toUnit): int
    {
        return (int) round($this->valueInMeter / $this->getMultiplier($toUnit));
    }

    private function getMultiplier(LengthUnit $unit): int
    {
        return match ($unit) {
            LengthUnit::Meter => 1,
            LengthUnit::Kilometer => 1000,
        };
    }
}
