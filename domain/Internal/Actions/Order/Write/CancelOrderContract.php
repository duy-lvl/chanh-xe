<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Order\Write;

interface CancelOrderContract
{
    public function handle(int $staffId, string $orderCode, string $reason): void;
}
