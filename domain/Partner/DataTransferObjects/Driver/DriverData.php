<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Driver;

use App\Models\Driver;
use Facades\Domain\Shared\Services\Image;

final readonly class DriverData
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $avatarUrl = null,
        public string $phone
        
    ) {
    }

    public static function fromModel(Driver $model): self
    {
        $avatarUrl = Image::getFileTemporaryUrl($model->avatar_url);
       
        return new self(
            id: $model->id,
            name: $model->name,
            phone: $model->phone,
            avatarUrl: $avatarUrl
        );
    }
}
