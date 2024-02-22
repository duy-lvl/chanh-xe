<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Driver;


final readonly class UpdateDriverData
{
    public function __construct(
        public int $id,
        public string $name,
        public string $phone        
    ) {
    }

    
}
