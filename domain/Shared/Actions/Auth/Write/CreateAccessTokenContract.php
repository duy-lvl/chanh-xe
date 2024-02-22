<?php

declare(strict_types=1);

namespace Domain\Shared\Actions\Auth\Write;

use Illuminate\Foundation\Auth\User as Authenticatable;

interface CreateAccessTokenContract
{
    public function handle(Authenticatable $account, string $deviceName): string;
}
