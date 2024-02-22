<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Order;

use Domain\CustomerFacing\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TrackingOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $checkpoints = collect([]);
        
        foreach ($this->checkpoints as $checkpoint) {
            foreach($checkpoint->permissions as $permission) {
                if ($permission->achievedAt === null) {
                    break;
                }
                $checkpoints->push(
                    [
                        'name' => $checkpoint->name,
                        'address' => $checkpoint->address,
                        'status' => $permission->permission,
                        'achieved_at' => $permission->achievedAt
                    ]
                );
            }
        }
        if ($this->confirmedAt !== null) {
            $checkpoints->prepend([
                'name' => null,
                'address' => null,
                'status' => OrderStatus::Confirmed,
                'achieved_at' => $this->confirmedAt
            ]);
        }
        $checkpoints->prepend([
            'name' => null,
            'address' => null,
            'status' => OrderStatus::Created,
            'achieved_at' => $this->createdAt
        ]);
        if ($this->isCancelled) {
            $checkpoints->push([
                'name' => null,
                'address' => null,
                'status' => 5,
                'achieved_at' => $this->cancelledAt
            ]);
        }
        $canBeCancelled=$this->canBeCancelled;
        return [
            'checkpoints' => $checkpoints,
            'can_be_cancelled' => $canBeCancelled,
            'can_be_paid' => $this->canBePaid
        ];
        // return [
        //     'checkpoints' => $this->checkpoints->map(fn ($checkpoint) => $checkpoint->toArray()),
        // ];
    }
}
