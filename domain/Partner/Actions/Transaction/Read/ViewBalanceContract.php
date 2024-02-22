<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Transaction\Read;

interface ViewBalanceContract
{
    public function handle(int $partnerId): int;
}
