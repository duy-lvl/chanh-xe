<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Price;

use App\Models\BoxSize;
use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\Enums\MassUnit;
use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Weight;

final readonly class BoxSizeData
{
    public function __construct(
        public int $id,
        public Dimensions $dimensions,
        public Weight $weight,
    ) {
    }

    public static function fromModel(BoxSize $boxSize): self
    {

        return new self(
            id: $boxSize->id,
            dimensions: new Dimensions(
                width: (int) $boxSize->max_width,
                height: (int) $boxSize->max_height,
                length: (int) $boxSize->max_length,
                unit: LengthUnit::Milimeter
            ),
            weight: new Weight(
                value: (int) $boxSize->max_weight,
                unit: MassUnit::Gram
            )
        );
    }
}
