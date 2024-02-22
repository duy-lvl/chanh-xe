<?php

declare(strict_types=1);

namespace Domain\Shared\Actions\Auth\Write\Implementations;

use Domain\Shared\Actions\Auth\Write\CreateAccessTokenContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

final class CreateAccessToken implements CreateAccessTokenContract
{
    public function handle(Authenticatable $account, string $deviceName): string
    {
        $token = $account->createToken($deviceName)->plainTextToken;

        return $token;
    }
}
