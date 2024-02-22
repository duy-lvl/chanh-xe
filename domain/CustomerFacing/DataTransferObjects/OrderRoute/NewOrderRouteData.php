<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\OrderRoute;

final class NewOrderRouteData
{
    public function __construct(
        public int $id,
        public bool $isSelected
    ) {
    }
}
