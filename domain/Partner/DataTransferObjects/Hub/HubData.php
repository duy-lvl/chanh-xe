<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Hub;

use App\Models\Hub;

final readonly class HubData
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $address = null,
        public ?float $latitude = null,
        public ?float $longitude = null,
    ) {
    }

    public static function fromModel(Hub $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            address: $model->address,
            latitude: $model->latitude === null ? null : (float) $model->latitude,
            longitude: $model->longitude === null ? null : (float) $model->longitude,
        );
    }
}
