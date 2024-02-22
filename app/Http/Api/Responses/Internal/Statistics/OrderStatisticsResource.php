<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Statistics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class OrderStatisticsResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'number_of_straight_orders' => $this->numberOfStraightOrders,
            'hub_orders' => $this->hubOrders->toArray()
        ];
    }
}
