<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Statistics;

final class YearlyRevenueData
{
    public function __construct(
        public int $month,
        public int $systemRevenue,
        public int $partnerRevenue,
        public int $companyRevenue
    ) { }

}
