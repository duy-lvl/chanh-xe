<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Order;

use App\Models\Hub;
use App\Models\Station;
use Illuminate\Support\Collection;

final readonly class CheckpointData
{
    /**
     * @param Collection<PermissionData> $permissions
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $address,
        public string $type,
        public Collection $permissions
    ) {
    }
    /**
     * @param Collection<PermissionData> $permissions
     */
    public static function fromModel(Station|Hub $model, Collection $permissions): self
    {
        
        return new self(
            id: $model->id,
            name: $model->name,
            address: $model->address,
            type: $model->getMorphClass(),
            permissions: $permissions
        );
    }

    public function toArray(): array
    {
        
        return [
            'name' => $this->name,
            'address' => $this->address,
            'type' => $this->type,
            'statuses' => $this->permissions->map(fn (PermissionData $permission) => $permission->toArray())
        ];
    }
}
