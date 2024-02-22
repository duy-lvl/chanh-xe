<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Statistics;

final  class MonthRevenueData
{
    public function __construct(
        public int $month,
        public int $revenue,
        
    ) { }
   
}
