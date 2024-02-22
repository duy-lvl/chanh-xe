<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Price;

use App\Models\BoxSize;
use Illuminate\Support\Collection;

final readonly class BoxSizeData
{
    public function __construct(
        public int $id,
        public float $maxWidth,
        public float $maxLength,
        public float $maxHeight,
        public float $maxWeight,
        /** @var Collection<PriceItemData> $prices */
        public Collection $prices,
    ) {
    }

    /**
     * @param  Collection<PriceItemData>  $prices
     */
    public static function fromModel(BoxSize $model, Collection $prices): self
    {
        return new self(
            id: $model->id,
            maxWidth: (float) $model->max_width,
            maxLength: (float) $model->max_length,
            maxHeight: (float) $model->max_height,
            maxWeight: (float) $model->max_weight,
            prices: $prices,
        );
    }
}
