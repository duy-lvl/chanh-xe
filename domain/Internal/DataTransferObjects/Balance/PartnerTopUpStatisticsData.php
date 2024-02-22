<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Balance;

final readonly class PartnerTopUpStatisticsData
{
    public function __construct(
        public int $month,
        public int $amount,
    ) {
    }
}
