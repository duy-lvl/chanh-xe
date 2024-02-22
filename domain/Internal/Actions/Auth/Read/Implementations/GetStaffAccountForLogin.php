<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Auth\Read\Implementations;

use App\Models\Staff;
use Domain\Internal\Actions\Auth\Read\GetStaffAccountForLoginContract;
use Domain\Internal\DataTransferObjects\Auth\LoginData;
use Domain\Shared\Enums\AccountStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class GetStaffAccountForLogin implements GetStaffAccountForLoginContract
{
    public function handle(LoginData $data): Staff
    {
        $account = Staff::where('username', $data->username)->first();

        if ( ! $account || ! Hash::check($data->password, $account->password)) {
            throw ValidationException::withMessages([
                'auth' => [__('auth.failed')],
            ]);
        }

        if ( ! $account || $account->status !== AccountStatus::Active) {
            throw ValidationException::withMessages([
                'auth' => [__('auth.inactive')],
            ]);
        }

        return $account;
    }
}
