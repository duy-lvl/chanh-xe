<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class AuthenticateResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customer' => [
                'id' => $this->id,
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'created_at' => $this->createdAt,
                'updated_at' => $this->updatedAt,
            ],
            'access_token' => $this->accessToken,
        ];
    }
}
