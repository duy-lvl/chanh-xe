<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Transaction\Write;

use Domain\Partner\Enums\TransactionRequestType;
use Illuminate\Http\UploadedFile;

interface CreateTransactionRequestContract
{
    public function handle(
        int $partnerId,
        int $amount,
        TransactionRequestType $type,
        ?UploadedFile $image = null
    ): bool;
}
