<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Transaction\Write\Implementations;

use App\Models\TransactionRequest;
use Domain\Internal\Actions\Transaction\Write\ProceedTopupTransactionContract;
use Domain\Partner\DataTransferObjects\Transaction\NewTransactionData;
use Domain\Partner\Enums\TransactionRequestType;
use Domain\Partner\Enums\WalletType;
use Domain\Partner\Services\TransactionManagement;

final class ProceedTopupTransaction implements ProceedTopupTransactionContract
{
    public function __construct (
        private readonly TransactionManagement $transactionManagementService,
    ){}
    public function handle(int $requestId): void
    {

        $request = TransactionRequest::findOrFail($requestId);
        
        if ($request->type == TransactionRequestType::Withdraw) {
            $request->amount *= -1;
        }

        $this->transactionManagementService->generateTransaction(
            partnerId: $request->partner_id,
            type: WalletType::Cash,
            data: new NewTransactionData(
                amount: $request->amount,
                description: __('messages.transaction.requestApproved', ['id' => $requestId]),
            ),
            requestId: $requestId
        );

    }
}
