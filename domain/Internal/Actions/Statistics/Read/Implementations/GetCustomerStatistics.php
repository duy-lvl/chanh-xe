<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read\Implementations;

use App\Models\Customer;
use Domain\Internal\Actions\Statistics\Read\GetCustomerStatisticsContract;

final class GetCustomerStatistics implements GetCustomerStatisticsContract
{
    public function handle(): int
    {
        return Customer::query()->count();
    }
}
