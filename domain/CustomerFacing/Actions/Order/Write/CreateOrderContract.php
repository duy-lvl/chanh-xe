<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Write;

use Domain\CustomerFacing\DataTransferObjects\Order\DetailedOrderData;
use Domain\CustomerFacing\DataTransferObjects\Order\NewOrderData;

interface CreateOrderContract
{
    public function handle(NewOrderData $data): DetailedOrderData;
}
