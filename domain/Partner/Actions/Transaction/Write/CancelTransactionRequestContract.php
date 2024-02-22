<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Transaction\Write;

interface CancelTransactionRequestContract
{
    public function handle(int $partnerId, int $requestId): bool;
}
