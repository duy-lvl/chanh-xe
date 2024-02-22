<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Partner;

use App\Models\Partner;
use DateTimeImmutable;
use Illuminate\Support\Collection;
use Facades\Domain\Shared\Services\Image;
final readonly class PartnerData
{
    /**
     * @param null|Collection<string>  $phones
     * @param null|Collection<StationData> $stations
    */
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description = null,
        public ?string $avatarUrl = null,
        public ?Collection $phones = null,
        public ?Collection $stations = null,
        public ?DateTimeImmutable $createdAt = null
    ) {
    }

    /**
     * @param null|Collection<string>  $phones
     * @param null|Collection<StationData> $stations
    */
    public static function fromModel(Partner $partner, ?Collection $phones = null, ?Collection $stations = null): self
    {
        $avatarUrl = Image::getFileTemporaryUrl($partner->avatar_url);

        return new self(
            id: $partner->id,
            name: $partner->name,
            description: $partner->description,
            avatarUrl: $avatarUrl,
            phones: $phones,
            stations: $stations,
            createdAt: $partner->created_at?->toImmutable()
        );
    }
}
