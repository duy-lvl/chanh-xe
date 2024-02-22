<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Auth\Write\Implementations;

use App\Models\Customer;
use Domain\CustomerFacing\Actions\Auth\Write\RegisterNewCustomerAccountContract;
use Domain\CustomerFacing\DataTransferObjects\Auth\NewCustomerData;
use Domain\Shared\Enums\AccountStatus;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class RegisterNewCustomerAccount implements RegisterNewCustomerAccountContract
{
    public function handle(NewCustomerData $userData): Customer
    {
        return DB::transaction(
            callback: function () use ($userData): Customer {
                $userModel = Customer::create(
                    attributes: [
                        'name' => $userData->name,
                        'phone' => $userData->phone,
                        'password' => Hash::make($userData->password),
                        'email' => $userData->email,
                        'status' => AccountStatus::Active,
                    ],
                );

                event(new Registered($userModel));

                return $userModel;
            },
            attempts: 3
        );
    }
}
