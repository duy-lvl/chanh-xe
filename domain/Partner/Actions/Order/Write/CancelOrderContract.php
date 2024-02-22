<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Write;

interface CancelOrderContract
{
    public function handle(int $partnerId, string $orderCode, string $reason): void;
}
