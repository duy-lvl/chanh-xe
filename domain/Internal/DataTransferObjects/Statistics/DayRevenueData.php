<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Statistics;

final class DayRevenueData
{
    public function __construct(
        public int $day,
        public int $revenue,
    ) { }
   
}
