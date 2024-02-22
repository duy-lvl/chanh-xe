<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Price;

use Domain\Internal\DataTransferObjects\Price\PriceData;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

final class BoxSizePriceResource extends JsonApiResource
{
    public function __construct(PriceData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'price';
    }

    public function toAttributes(Request $request): array
    {
        return [
            'apply_from' => $this->applyFrom,
            'apply_to' => $this->applyTo,
            'name' => $this->name,
            'priority' => $this->priority,
            'note' => $this->note ?? null,
            'items' => $this->items,
        ];
    }
}
