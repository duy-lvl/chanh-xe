<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Order;

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
        public Collection $permissions,
        public ?array $driver = null,
        public ?array $vehicle = null,
    ) {
    }
    /**
     * @param Collection<PermissionData> $permissions
     */
    public static function fromModel(Station|Hub $model, Collection $permissions, ?DriverData $driver = null, ?VehicleData $vehicle = null): self
    {
        
        return new self(
            id: $model->id,
            name: $model->name,
            address: $model->address,
            type: $model->getMorphClass(),
            permissions: $permissions->map(fn (PermissionData $permission) => $permission->toArray()),
            driver: $driver?->toArray(),
            vehicle: $vehicle?->toArray(),
        );
    }
}
