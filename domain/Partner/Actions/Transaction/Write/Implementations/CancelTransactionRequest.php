<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Transaction\Write\Implementations;

use App\Exceptions\TransactionException;
use App\Models\TransactionRequest;
use DB;
use Domain\Partner\Actions\Transaction\Write\CancelTransactionRequestContract;

final class CancelTransactionRequest implements CancelTransactionRequestContract
{
    public function handle(int $partnerId, int $requestId): bool
    {
        $request = TransactionRequest::withCount('transaction')->findOrFail($requestId);
        
        if ($request->partner_id !== $partnerId)
        {
            throw TransactionException::Unauthorize();
        }
        if ($request->transaction_count > 0) {
            throw TransactionException::TransactionHasBeenProceeded();
        }
        return DB::transaction(
            callback: function () use ($requestId): bool {
                return TransactionRequest::query()->where('id', $requestId)->delete() > 0;
            },
            attempts: 3
        );
    }
}
