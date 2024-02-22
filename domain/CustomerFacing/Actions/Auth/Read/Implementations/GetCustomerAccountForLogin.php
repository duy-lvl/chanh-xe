<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Auth\Read\Implementations;

use App\Models\Customer;
use Domain\CustomerFacing\Actions\Auth\Read\GetCustomerAccountForLoginContract;
use Domain\CustomerFacing\DataTransferObjects\Auth\LoginData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class GetCustomerAccountForLogin implements GetCustomerAccountForLoginContract
{
    public function handle(LoginData $data): Customer
    {
        $account = Customer::query()
            ->where('phone', $data->indentifier)
            ->orWhere('email', $data->indentifier)
            ->first();

        if ( ! $account || ! Hash::check($data->password, $account->password)) {
            throw ValidationException::withMessages([
                'auth' => [__('auth.failed')],
            ]);
        }

        return $account;
    }
}
