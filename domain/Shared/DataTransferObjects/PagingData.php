<?php

declare(strict_types=1);

namespace Domain\Shared\DataTransferObjects;

use Domain\Shared\Constants\DefaultConstant;

final readonly class PagingData
{
    public function __construct(
        public int $page = 1,
        public int $perPage = DefaultConstant::PER_PAGE,
    ) {
    }
}
