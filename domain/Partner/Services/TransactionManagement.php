<?php

declare(strict_types=1);

namespace Domain\Partner\Services;

use App\Exceptions\TransactionException;
use App\Models\Transaction;
use App\Models\Wallet;
use Domain\Partner\DataTransferObjects\Transaction\NewTransactionData;
use Domain\Partner\Enums\WalletType;
use Illuminate\Support\Facades\DB;

final class TransactionManagement
{
    public function generateTransaction(int $partnerId, WalletType $type, NewTransactionData $data, ?int $requestId = null): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $type, $data, $requestId): void {
                if (null !== $requestId) {
                    throw_if(
                        Transaction::query()->where('request_id', $requestId)->count() > 0,
                        TransactionException::TransactionHasBeenProceeded(),
                    );
                }

                $wallet = Wallet::query()->where('partner_id', $partnerId)->where('type', $type)->firstOrFail();

                $wallet->increment('balance', $data->amount);

                $wallet->transactions()->create([
                    'amount' => $data->amount,
                    'description' => $data->description,
                    'request_id' => $requestId ?? null,
                ]);
            },
            attempts: 3
        );
    }

    public function rebalanceWallets(int $partnerId): void
    {
        DB::transaction(
            callback: function () use ($partnerId): void {
                $wallets = Wallet::query()->where('partner_id', $partnerId)->get();

                $mainWallet = $wallets->where('type', WalletType::Cash)->first();
                $revenueWallet = $wallets->where('type', WalletType::Revenue)->first();
                $cobWallet = $wallets->where('type', WalletType::CollectionOnBehalf)->first();

                $mainWalletDisparity = ($revenueWallet->balance) - ($cobWallet->balance);

                $mainWallet->increment('balance', $mainWalletDisparity);
                $revenueWallet->update(['balance' => 0]);
                $cobWallet->update(['balance' => 0]);

                // $mainWallet->transactions()->create([
                //     'amount' => $mainWalletDisparity,
                //     'descriptions' => 'Wallet re-, +' . $revenueWallet->balance . 'from revenue, -' . $cobWallet->balance . 'from collection on behalf',
                // ]);
                // $revenueWallet->transactions()->create([
                //     'amount' => -($revenueWallet->balance),
                //     'descriptions' => 'Wallet re-balancing, add to main wallet',
                // ]);
                // $cobWallet->transactions()->create([
                //     'amount' => -($cobWallet->balance),
                //     'descriptions' => 'Wallet re-balancing, subtract from main wallet',
                // ]);
            },
            attempts: 3
        );
    }
}
