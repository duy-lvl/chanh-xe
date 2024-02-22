<?php

declare(strict_types=1);

namespace Domain\Shared\Actions\Auth\Write;

use Illuminate\Foundation\Auth\User as Authenticatable;

interface UpdatePasswordContract
{
    public function handle(Authenticatable $account, string $password): Authenticatable;
}
