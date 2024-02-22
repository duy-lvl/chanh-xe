<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

final class CreateOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => Str::upper($this->code),
            'email' => $this->senderEmail,
        ];
    }
}
