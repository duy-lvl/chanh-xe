<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Write;

use Illuminate\Http\UploadedFile;

interface UpdateDoneStatusContract
{
    public function handle(int $partnerId, string $orderCode, string $receiveToken, UploadedFile $image): bool;
}
