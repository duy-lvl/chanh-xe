<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Statistics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PartnerResource extends JsonResource
{
    public function toArray(Request $request): array {
        return [
            'number_of_active_partners' => $this->resource['active'],
            'number_of_inactive_partners' => $this->resource['inactive']
        ];
    }
}
