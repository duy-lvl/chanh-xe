<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class OrderPaymentStatusResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'is_paid' => $this->resource,
        ];
    }
}
