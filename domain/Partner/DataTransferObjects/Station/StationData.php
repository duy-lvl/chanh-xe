<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Station;

use App\Models\Station;
use Domain\Partner\Enums\StationStatus;

final readonly class StationData
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $address,
        public ?float $latitude = null,
        public ?float $longitude = null,
        public StationStatus $status,
        public int $cityCode,
        public int $districtCode,
        public ?string $avatarUrl = null    
    ) {
    }

    public static function fromModel(Station $model, ?string $avatarUrl = null): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            address: $model->address,
            latitude: null === $model->latitude ? null : (float) $model->latitude,
            longitude: null === $model->longitude ? null : (float) $model->longitude,
            status: $model->status,
            cityCode: $model->city_code,
            districtCode: $model->district_code,
            avatarUrl: $avatarUrl
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'status' => $this->status,
            'city_code' => $this->cityCode,
            'district_code' => $this->districtCode,
            
        ];
    }
}
