<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Price;

use App\Models\PriceItem;

final readonly class PriceItemData
{
    public function __construct(
        // public int $id,
        public float $fromKilometer,
        public float $toKilometer,
        public int $pricePerKilometer,
        public int $minAmount,
        public int $maxAmount,
    ) {
    }

    public static function fromModel(PriceItem $model): self
    {
        return new self(
            // id: $model->id,
            fromKilometer: (float) $model->from_kilometer,
            toKilometer: (float) $model->to_kilometer,
            pricePerKilometer: (int) $model->price_per_kilometer,
            minAmount: (int) $model->min_amount,
            maxAmount: (int) $model->max_amount,
        );
    }
}
