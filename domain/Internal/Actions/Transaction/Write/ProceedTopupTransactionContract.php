<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Transaction\Write;

interface ProceedTopupTransactionContract
{
    public function handle(int $requestId): void;
}
