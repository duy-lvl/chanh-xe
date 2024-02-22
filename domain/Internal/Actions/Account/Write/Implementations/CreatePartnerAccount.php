<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Account\Write\Implementations;

use App\Events\PartnerAccountCreated;
use App\Models\Partner;
use Domain\Internal\Actions\Account\Write\CreatePartnerAccountContract;
use Domain\Internal\DataTransferObjects\Account\NewPartnerAccountData;
use Domain\Internal\DataTransferObjects\Account\PartnerAccountData;
use Domain\Partner\Enums\WalletType;
use Domain\Shared\Enums\AccountStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class CreatePartnerAccount implements CreatePartnerAccountContract
{
    public function handle(NewPartnerAccountData $data): PartnerAccountData
    {
        return DB::transaction(
            callback: function () use ($data): PartnerAccountData {
                $newPassword = Str::password(length: 12, symbols: false);

                $account = Partner::query()->create([
                    'username' => $data->username,
                    'password' => Hash::make($newPassword),
                    'name' => $data->name,
                    'status' => AccountStatus::Active,
                    'bank_account_name' => $data->bankAccountName,
                    'bank_code' => $data->bankCode,
                    'bank_account_number' => $data->bankAccountNumber,

                ]);

                $account->wallets()->createMany([
                    ['type' => WalletType::Cash],
                    ['type' => WalletType::Revenue],
                    ['type' => WalletType::CollectionOnBehalf],
                ]);

                $accountData = new PartnerAccountData(
                    id: $account->id,
                    name: $account->name,
                    username: $account->username,
                    password: $newPassword,
                    bankCode: $account->bank_code,
                    bankAccountNumber: $account->bank_account_number,
                    bankAccountName: $account->bank_account_name,
                    createdAt: $account->created_at?->toImmutable(),
                    updatedAt: $account->updated_at?->toImmutable(),
                    phones: null,
                    status: $account->status,
                );

                // PartnerAccountCreated::dispatch($accountData);

                return $accountData;
            },
            attempts: 3
        );
    }
}
