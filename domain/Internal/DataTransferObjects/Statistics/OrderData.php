<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Statistics;

use App\Models\Customer;
use Illuminate\Support\Collection;

final readonly class OrderData
{
    /**
     * @param Collection<HubOrderData> $hubOrders
     */
    public function __construct(
        public int $numberOfStraightOrders,
        public Collection $hubOrders
    ) {
    }

}
