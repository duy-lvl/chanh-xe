<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Account\Write\Implementations;

use App\Events\StaffAccountCreated;
use App\Models\Staff;
use Domain\Internal\Actions\Account\Write\CreateStaffAccountContract;
use Domain\Internal\DataTransferObjects\Account\NewStaffAccountData;
use Domain\Internal\DataTransferObjects\Account\StaffAccountData;
use Domain\Shared\Enums\AccountStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class CreateStaffAccount implements CreateStaffAccountContract
{
    public function handle(NewStaffAccountData $data): StaffAccountData
    {
        return DB::transaction(
            callback: function () use ($data): StaffAccountData {
                $newPassword = Str::password(length: 12, symbols: false);

                $account = Staff::query()->create(
                    attributes: [
                        'username' => $data->username,
                        'password' => Hash::make($newPassword),
                        'email' => $data->email,
                        'hub_id' => $data->hubId,
                        'status' => AccountStatus::Active,
                    ],
                );

                $accountData = new StaffAccountData(
                    id: $account->id,
                    email: $account->email,
                    username: $account->username,
                    hubId: (int) $account->hub_id,
                    password: $newPassword,
                    createdAt: $account->created_at?->toImmutable(),
                    updatedAt: $account->updated_at?->toImmutable(),
                    hubData: null,
                    status: $account->status
                );

                StaffAccountCreated::dispatch($accountData);

                return $accountData;
            },
            attempts: 3
        );
    }
}
