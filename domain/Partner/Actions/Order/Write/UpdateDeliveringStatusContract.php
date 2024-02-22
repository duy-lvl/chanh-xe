<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Write;

interface UpdateDeliveringStatusContract
{
    public function handle(int $partnerId, string $orderCode, int $vehicleId, int $driverId): void;
}
