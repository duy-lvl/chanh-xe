<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Order;

use App\Models\Vehicle;
use Facades\Domain\Shared\Services\Image;

final readonly class VehicleData
{
    public function __construct(
        public int $id,
        public string $plateNumber,
        public string $type,
        public ?string $imageUrl = null
    ) {
    }

    public static function fromModel(Vehicle $model): self
    {
        $imageUrl = Image::getFileTemporaryUrl($model->image_url);
        
        return new self(
            id: $model->id,
            type: $model->type,
            plateNumber: $model->plate_number,
            imageUrl: $imageUrl
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'plate_number' => $this->plateNumber,
            'image_url' => $this->imageUrl
        ];
    }
}