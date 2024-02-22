<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class LoginTokenResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'partner' => [
                'id' => $this->id,
                'username' => $this->username,
                'name' => $this->name,
                'created_at' => $this->createdAt,
                'updated_at' => $this->updatedAt,
            ],
            'access_token' => $this->accessToken,
        ];
    }
}
