<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Partner;

use App\Models\Station;

final readonly class StationData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $address,
    ) {
    }
    public static function fromModel(Station $model): self
    {
        
        return new self(
            id: $model->id,
            name: $model->name,
            address: $model->address,
        );
    }
}
