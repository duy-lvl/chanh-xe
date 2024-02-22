<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Vehicle;

use App\Models\Vehicle;
use Facades\Domain\Shared\Services\Image;

final readonly class VehicleData
{
    public function __construct(
        public int $id,
        public string $type,
        public string $imageUrl,
        public string $plateNumber,
        
    ) {
    }

    public static function fromModel(Vehicle $model): self
    {
        $imageUrl = Image::getFileTemporaryUrl($model->image_url);
      
        return new self(
            id: $model->id,
            plateNumber:$model->plate_number,
            type: $model->type,
            imageUrl: $imageUrl,
        );
    }
}
