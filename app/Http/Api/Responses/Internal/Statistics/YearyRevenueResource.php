<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Statistics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class YearyRevenueResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'month' => $this->resource->month,
            'company_revenue' => $this->resource->companyRevenue,
            'partner_revenue' => $this->resource->partnerRevenue,
            'system_revenue' => $this->resource->systemRevenue
        ];
    }
}
