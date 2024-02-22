<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Statistics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class DayRevenueResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'day' => $this->resource->day,
            'revenue' => $this->resource->revenue
        ];
    }
}
