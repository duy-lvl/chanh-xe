<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read;

use Domain\Internal\DataTransferObjects\Balance\CustomerDirectPaymentStatisticsData;
use Illuminate\Support\Collection;

interface GetCustomerDirectPaymentStatisticsContract
{
    /**
     * @return Collection<CustomerDirectPaymentStatisticsData>
     */
    public function handle(int $year): Collection;
}
