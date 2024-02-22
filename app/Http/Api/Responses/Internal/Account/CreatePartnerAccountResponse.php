<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreatePartnerAccountResponse extends JsonResource
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
                'generated_password' => $this->password,
                'phones' => $this->phones,
                'created_at' => $this->createdAt,
                'updated_at' => $this->updatedAt,
            ],
        ];
    }
}
