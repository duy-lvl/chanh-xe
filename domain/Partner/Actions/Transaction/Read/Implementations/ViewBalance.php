<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Transaction\Read\Implementations;

use App\Models\Partner;
use Domain\Partner\Actions\Transaction\Read\ViewBalanceContract;

final class ViewBalance implements ViewBalanceContract
{
    public function handle(int $partnerId): int
    {
        return (int) Partner::findOrFail($partnerId)->balance;
    }
}
