<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Transaction\Write\Implementations;

use App\Models\TransactionRequest;
use Domain\Internal\Actions\Transaction\Write\ProceedWithdrawTransactionContract;
use Domain\Partner\DataTransferObjects\Transaction\NewTransactionData;
use Domain\Partner\Enums\TransactionRequestType;
use Domain\Partner\Enums\WalletType;
use Domain\Partner\Services\TransactionManagement;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class ProceedWithdrawTransaction implements ProceedWithdrawTransactionContract
{
    public function __construct (
        private readonly TransactionManagement $transactionManagementService,
    ){}
    public function handle(int $requestId, UploadedFile $image): void
    {

        $request = TransactionRequest::findOrFail($requestId);
        
        $imageUrl = null;
        if ($image !== null) {
            $imageUrl = Storage::disk('s3')->putFile('transaction_requests', $image, 'public');
        }
        $request->image_url = $imageUrl;
        $request->save();
        
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
