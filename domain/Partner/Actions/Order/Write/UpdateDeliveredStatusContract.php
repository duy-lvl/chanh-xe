<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Write;

interface UpdateDeliveredStatusContract
{
    public function handle(int $partnerId, string $orderCode): bool;
}
