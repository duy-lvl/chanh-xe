<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Read;

use Domain\CustomerFacing\DataTransferObjects\Order\DetailedOrderData;

interface GetOrderDetailContract
{
    public function handle(string $code): ?DetailedOrderData;
}
