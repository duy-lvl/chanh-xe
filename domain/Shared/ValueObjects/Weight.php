<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObjects;

use Domain\Shared\Enums\MassUnit;

final class Weight
{
    private readonly int $valueInGram;

    /**
     * @param  int  $value can only be int, even in larger units.
     */
    public function __construct(int $value, MassUnit $unit = MassUnit::Gram)
    {
        $multiplier = $this->getMultiplier($unit);

        $this->valueInGram = $value * $multiplier;
    }

    public function value(): int
    {
        return $this->valueInGram;
    }

    public function convertValue(MassUnit $toUnit): int|float
    {
        return $this->valueInGram / $this->getMultiplier($toUnit);
    }

    private function getMultiplier(MassUnit $unit): int
    {
        return match ($unit) {
            MassUnit::Gram => 1,
            MassUnit::Kilogram => 1000,
        };
    }
}
