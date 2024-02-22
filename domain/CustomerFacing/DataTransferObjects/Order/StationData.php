<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Order;

use App\Models\Station;
use Illuminate\Support\Collection;
use Facades\Domain\Shared\Services\Image;
final readonly class StationData
{
    /**
     * @param null|Collection<string> $partnerPhones
     */
    public function __construct(
        public int $id,
        public string $name,
        public ?string $address = null,
        public ?Collection $partnerPhones = null,
        public ?string $imageUrl = null
    ) {
    }

    /**
     * @param null|Collection<string> $partnerPhones
     */
    public static function fromModel(Station $model, ?Collection $partnerPhones = null, ?string $imageUrl = null): self
    {
        $partnerImageUrl = Image::getFileTemporaryUrl($imageUrl);
       
        return new self(
            id: $model->id,
            name: $model->name,
            address: $model->address,
            partnerPhones: $partnerPhones,
            imageUrl: $partnerImageUrl
        );
    }
}
