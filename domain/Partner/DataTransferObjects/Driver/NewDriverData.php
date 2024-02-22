<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Driver;

use Illuminate\Http\UploadedFile;

final readonly class NewDriverData
{
    public function __construct(
        public string $name,
        public UploadedFile $avatar,
        public string $phone,
        public int $partnerId 
    ) {
    }

    
}
