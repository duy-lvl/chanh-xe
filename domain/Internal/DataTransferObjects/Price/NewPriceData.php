<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Price;

use DateTimeImmutable;
use Domain\Internal\Enums\PriceTableStatus;
use Illuminate\Support\Collection;

final readonly class NewPriceData
{
    /**
     * @param  Collection<PriceItemData>  $items
     */
    public function __construct(
        public DateTimeImmutable $applyFrom,
        public DateTimeImmutable $applyTo,
        public string $name,
        public int $priority,
        public PriceTableStatus $status,
        public Collection $items,
        public ?string $note = null,
    ) {
    }

    public function toArray(): array
    {
        $items = $this->items->map(fn ($item) => $item->toArray());

        return [
            'apply_from' => $this->applyFrom,
            'apply_to' => $this->applyTo,
            'name' => $this->name,
            'priority' => $this->priority,
            'status' => $this->status,
            'items' => $items,
            'note' => $this->note,
        ];
    }
}
