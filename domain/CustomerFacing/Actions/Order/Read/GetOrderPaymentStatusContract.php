<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Read;

interface GetOrderPaymentStatusContract
{
    public function handle(string $code): bool;
}
