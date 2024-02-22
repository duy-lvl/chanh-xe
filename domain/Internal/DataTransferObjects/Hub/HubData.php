<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Hub;

use App\Models\Hub;
use App\Models\Staff;
use DateTimeImmutable;
use Domain\Internal\DataTransferObjects\Profile\ProfileData;
use Illuminate\Support\Collection;

final readonly class HubData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $address,
        public float $latitude,
        public float $longitude,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
        /** @var Collection<ProfileData> $staffs */
        public ?Collection $staffs = null,
    ) {
    }

    /**
     * @param  Collection<Staff>  $staffs
     */
    public static function fromModel(Hub $hub, ?Collection $staffs = null): self
    {
        return new self(
            id: $hub->id,
            name: $hub->name,
            address: $hub->address,
            latitude: (float) $hub->latitude,
            longitude: (float) $hub->longitude,
            createdAt: $hub->created_at?->toImmutable(),
            updatedAt: $hub->updated_at?->toImmutable(),
            staffs: null === $staffs ? null : $staffs->map(fn (Staff $staff) => ProfileData::fromModel($staff))
        );
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'latitude' => (float) $this->latitude,
            'longitude' => (float) $this->longitude,
        ];
    }
}
