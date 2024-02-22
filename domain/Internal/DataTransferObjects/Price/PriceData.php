<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Price;

use App\Models\BoxSizePrice;
use DateTimeImmutable;
use Domain\CustomerFacing\Enums\PriceStatus;
use Illuminate\Support\Collection;

final readonly class PriceData
{
    /**
     * @param  Collection<PriceItemData>  $items
     */
    public function __construct(
        public int $id,
        public DateTimeImmutable $applyFrom,
        public DateTimeImmutable $applyTo,
        public string $name,
        public int $priority,
        public ?string $note = null,
        public PriceStatus $status,
        public Collection $items
    ) {
    }

    /**
     * @param  Collection<PriceItemData>  $items
     */
    public static function fromModel(BoxSizePrice $model, Collection $items): self
    {

        return new self(
            id: $model->id,
            applyFrom: $model->apply_from->toImmutable(),
            applyTo: $model->apply_to->toImmutable(),
            name: $model->name,
            priority: $model->priority,
            status: $model->status,
            items: $items,
            note: $model->note ?? null
        );
    }
}
