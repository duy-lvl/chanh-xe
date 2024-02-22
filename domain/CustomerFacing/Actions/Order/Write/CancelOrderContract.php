<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Write;

use Domain\CustomerFacing\DataTransferObjects\Order\NewOrderData;

interface CancelOrderContract
{
    /**
     * @param null|int $customerId
     * @param null|string $identifier
     */
    public function handle(?int $customerId, ?string $identifier, string $orderCode): void;
}
