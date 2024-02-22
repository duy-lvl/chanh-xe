<?php

declare(strict_types=1);

namespace Domain\Auth\Actions\Write;

use App\Models\User;
use Domain\Auth\DataTransferObjects\NewUserData;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

final class RegisterNewUser
{
    public function handle(NewUserData $user): Model|User
    {
        $result = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => Hash::make($user->password),
        ]);

        event(new Registered($user));

        return $result;
    }
}
