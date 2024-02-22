<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Driver\Write;

use Illuminate\Http\UploadedFile;

interface UpdateDriverAvatarContract
{
    public function handle(int $partnerId, int $driverId, UploadedFile $avatar): void;
}
