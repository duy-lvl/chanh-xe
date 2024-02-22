<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class GetPaymentUrlResource extends JsonResource
{


    public function toArray(Request $request): array
    {
        return ['data' => $this->resource];
    }
}
