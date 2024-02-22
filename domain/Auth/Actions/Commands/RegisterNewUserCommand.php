<?php declare(strict_types=1);

namespace Domain\Auth\Actions\Commands;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Domain\Auth\DataTransferObjects\NewUserData;

final class RegisterNewUserCommand
{
    public function handle(NewUserData $user): Model|User
    {
        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => Hash::make($user->password),
        ]);
    }
}
