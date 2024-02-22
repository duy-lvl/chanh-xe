<?php

declare(strict_types=1);

namespace Domain\PathFinding\DataTransferObjects;

final readonly class Path
{
    public function __construct(
        public array $sequence,
        public int|float $cost,
    ) {
    }
}
