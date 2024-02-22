<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Auth\Read\Implementations;

use App\Models\Partner;
use Domain\Partner\Actions\Auth\Read\GetPartnerAccountForLoginContract;
use Domain\Partner\DataTransferObjects\Auth\LoginData;
use Domain\Shared\Enums\AccountStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class GetPartnerAccountForLogin implements GetPartnerAccountForLoginContract
{
    public function handle(LoginData $data): Partner
    {
        $account = Partner::where('username', $data->username)->first();

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
