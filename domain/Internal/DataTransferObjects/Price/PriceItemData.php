<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Price;

use App\Models\PriceItem;

final readonly class PriceItemData
{
    public function __construct(
        public int $fromKilometer,
        public int $toKilometer,
        public int $pricePerKilometer,
        public int $minAmount,
        public int $maxAmount,
    ) {
    }

    public static function fromModel(PriceItem $item): self
    {
        return new self(
            fromKilometer: (int) $item->from_kilometer,
            toKilometer: (int) $item->to_kilometer,
            pricePerKilometer: (int) $item->price_per_kilometer,
            minAmount: (int) $item->min_amount,
            maxAmount: (int) $item->max_amount
        );
    }

    public function toArray(): array
    {
        return [
            'from_kilometer' => $this->fromKilometer,
            'to_kilometer' => $this->toKilometer,
            'price_per_kilometer' => $this->pricePerKilometer,
            'min_amount' => $this->minAmount,
            'max_amount' => $this->maxAmount,
        ];
    }
}
