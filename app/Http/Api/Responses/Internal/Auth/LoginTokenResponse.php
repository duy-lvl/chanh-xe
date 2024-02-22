<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Auth;

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
            'staff' => [
                'id' => $this->id,
                'username' => $this->username,
                'email' => $this->email,
                'hub_name' => $this->hubName,
                'created_at' => $this->createdAt,
                'updated_at' => $this->updatedAt,
            ],
            'access_token' => $this->accessToken,
        ];
    }
}
