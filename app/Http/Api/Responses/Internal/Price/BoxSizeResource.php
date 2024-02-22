<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Price;

use Domain\Internal\DataTransferObjects\Price\BoxSizeData;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

final class BoxSizeResource extends JsonApiResource
{
    public function __construct(BoxSizeData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'box_size';
    }

    public function toAttributes(Request $request): array
    {
        return [
            'max_length' => $this->dimensions->length(),
            'max_width' => $this->dimensions->width(),
            'max_height' => $this->dimensions->height(),
            'max_weight' => $this->weight->value(),
        ];
    }
}
