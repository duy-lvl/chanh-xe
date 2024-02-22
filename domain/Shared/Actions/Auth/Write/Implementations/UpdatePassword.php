<?php

declare(strict_types=1);

namespace Domain\Shared\Actions\Auth\Write\Implementations;

use Domain\Shared\Actions\Auth\Write\UpdatePasswordContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class UpdatePassword implements UpdatePasswordContract
{
    public function handle(Authenticatable $account, string $password): Authenticatable
    {
        return DB::transaction(
            callback: function () use ($account, $password) {
                $account->password = Hash::make($password);
                $account->save();

                return $account;
            },
            attempts: 3,
        );
    }
}
