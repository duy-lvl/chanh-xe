<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Transaction\Write;

use Illuminate\Http\UploadedFile;

interface ProceedWithdrawTransactionContract
{
    public function handle(int $requestId, UploadedFile $image): void;
}
