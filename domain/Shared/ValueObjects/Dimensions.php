<?php

declare(strict_types=1);

namespace Domain\Shared\ValueObjects;

use Domain\Shared\Enums\LengthUnit;

final class Dimensions
{
    private readonly int $widthInMm;

    private readonly int $heightInMm;

    private readonly int $lengthInMm;

    /**
     * @param  int  $width can only be int, even in larger units.
     * @param  int  $height can only be int, even in larger units.
     * @param  int  $length can only be int, even in larger units.
     */
    public function __construct(int $width, int $height, int $length, LengthUnit $unit = LengthUnit::Centimeter)
    {
        $multiplier = $this->getMultipler($unit);

        $this->widthInMm = $width * $multiplier;
        $this->heightInMm = $height * $multiplier;
        $this->lengthInMm = $length * $multiplier;
    }

    public function width(): int
    {
        return $this->widthInMm;
    }

    public function height(): int
    {
        return $this->heightInMm;
    }

    public function length(): int
    {
        return $this->lengthInMm;
    }

    public function convertWidth(LengthUnit $unit = LengthUnit::Centimeter): int|float
    {
        return $this->widthInMm / $this->getMultipler($unit);
    }

    public function convertHeight(LengthUnit $unit = LengthUnit::Centimeter): int|float
    {
        return $this->heightInMm / $this->getMultipler($unit);
    }

    public function convertLength(LengthUnit $unit = LengthUnit::Centimeter): int|float
    {
        return $this->lengthInMm / $this->getMultipler($unit);
    }

    private function getMultipler(LengthUnit $unit): int
    {
        return match ($unit) {
            LengthUnit::Milimeter => 1,
            LengthUnit::Centimeter => 10,
            LengthUnit::Decimeter => 100,
            LengthUnit::Meter => 1000,
        };
    }
}
