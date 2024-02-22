<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Order\Write;

interface StaffUpdateDeliveringStatusContract
{
    public function handle(int $staffId, string $orderCode, int $driverId, int $vehicleId): void;
}
