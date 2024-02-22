<?php

declare(strict_types=1);

namespace App\Http\Api\Resources\Auth\CustomerFacing\Auth;

use TiMacDonald\JsonApi\JsonApiResource;

final class UserResource extends JsonApiResource
{
    /**
     * @var string[]
     */
    public $attributes = [
        'fullname',
        'phone',
        'email',
    ];

    /**
     * @var array<string, class-string<JsonApiResource>>
     */
    public $relationships = [
        'address' => AddressResource::class,
        'token' => TokenResource::class,
    ];
}
