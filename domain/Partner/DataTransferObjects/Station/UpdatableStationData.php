<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Station;

use Domain\Partner\Enums\StationStatus;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

final readonly class UpdatableStationData
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
