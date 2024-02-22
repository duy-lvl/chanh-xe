<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Price;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class GetPriceResponse extends JsonResource
{
    public function __construct(?int $resource)
    {
        $this->resource = $resource;
    }

    public function toArray(Request $request): array
    {
        return [
            'total_price' => $this->resource,
        ];
    }
}
