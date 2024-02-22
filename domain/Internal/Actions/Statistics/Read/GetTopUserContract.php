<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read;

use Domain\Internal\DataTransferObjects\Statistics\TopCustomerData;
use Illuminate\Support\Collection;

interface GetTopUserContract
{
    /**
     * @return Collection<TopCustomerData>
     */
    public function handle(int $numberOfCustomer = 10): Collection;
}
