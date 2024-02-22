<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Payment\Read;

interface GetPaymentUrlContract
{
    public function handle(?int $customerId, string $orderCode, string $ipAddress): string;
}