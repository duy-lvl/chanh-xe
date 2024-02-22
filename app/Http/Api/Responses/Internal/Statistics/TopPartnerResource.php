<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Statistics;

use Domain\Internal\DataTransferObjects\Statistics\TopPartnerData;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

final class TopPartnerResource extends JsonApiResource
{
    public function __construct(TopPartnerData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'partner';
    }

    public function toAttributes(Request $request): array {
        return [
            'name' => $this->name,
            'number_of_orders' => $this->numberOfOrder,
            'avatar_url' => $this->avatarUrl,
        ];
    }
}
