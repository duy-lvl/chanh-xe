<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class BalanceResource extends JsonResource
{
    public function __construct(int $resource)
    {
        $this->resource = $resource;
    }
    public function toArray(Request $request): array
    {  
        return [
            'balance' => $this->resource
        ];
    }
}
