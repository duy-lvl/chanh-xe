<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Transaction\Write\Implementations;

use App\Exceptions\TransactionException;
use App\Models\Partner;
use App\Models\TransactionRequest;
use DB;
use Domain\Partner\Actions\Transaction\Write\CreateTransactionRequestContract;
use Domain\Partner\Enums\TransactionRequestType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class CreateTransactionRequest implements CreateTransactionRequestContract
{
    
    public function handle(
        int $partnerId,
        int $amount,
        TransactionRequestType $type,
        ?UploadedFile $image = null
    ): bool
    {
        $partner = Partner::findOrFail($partnerId);
        
        if ($type == TransactionRequestType::Withdraw && $partner->balance < $amount)
        {
            throw TransactionException::InsufficentBalanceException();
        }
        $imageUrl = null;
        if ($image !== null) {
            $imageUrl = Storage::disk('s3')->putFile('transaction_requests', $image, 'public');
        }
        return DB::transaction(
            callback: function () use ($partnerId, $amount, $type, $imageUrl): bool {
                return TransactionRequest::query()->create(
                    attributes: [
                        'partner_id' => $partnerId,
                        'amount' => $amount,
                        'type' => $type,
                        'image_url' => $imageUrl
                    ]
                ) !== null;
            },
            attempts: 3
        );
    }
}
