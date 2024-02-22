<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Write;

use Illuminate\Http\UploadedFile;

interface AcceptOrderContract
{
    public function handle(int $partnerId, string $orderCode, UploadedFile $image): void;
}
