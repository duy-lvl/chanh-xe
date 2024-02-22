<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreateStaffAccountResponse extends JsonResource
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
                'hub_id' => $this->hubId,
                'generated_password' => $this->password,
                'created_at' => $this->createdAt,
                'updated_at' => $this->updatedAt,
            ],
        ];
    }
}
