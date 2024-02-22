<?php

declare(strict_types=1);

namespace App\Http\Api\Resources\Auth\CustomerFacing\Auth;

use TiMacDonald\JsonApi\JsonApiResource;

final class AddressResource extends JsonApiResource
{
    /**
     * @var string[]
     */
    public $attributes = [
        'city',
        'district',
        'ward',
        'street',
        'latitude',
        'longitude',
    ];

    /**
     * @var array<string, class-string<JsonApiResource>>
     */
    public $relationships = [
        'user' => UserResource::class,
    ];
}
