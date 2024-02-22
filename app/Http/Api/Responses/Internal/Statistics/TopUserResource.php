<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Statistics;

use Domain\Internal\DataTransferObjects\Statistics\TopCustomerData;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

final class TopUserResource extends JsonApiResource
{
    public function __construct(TopCustomerData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'customer';
    }

    public function toAttributes(Request $request): array {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'number_of_orders' => $this->numberOfOrder,
        ];
    }
}
