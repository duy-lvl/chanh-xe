<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Balance;

use Illuminate\Http\Request;
use Domain\Partner\Enums\WalletType;
use TiMacDonald\JsonApi\JsonApiResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Domain\Internal\DataTransferObjects\Balance\OrderRevenueStatisticsData;

final class OrderRevenueStatisticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'amount' => $this->amount,
            'month' => $this->month
        ];
    }
}
