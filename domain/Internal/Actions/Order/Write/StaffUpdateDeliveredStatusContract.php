<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Order\Write;

interface StaffUpdateDeliveredStatusContract
{
    public function handle(int $staffId, string $orderCode): void;
}
