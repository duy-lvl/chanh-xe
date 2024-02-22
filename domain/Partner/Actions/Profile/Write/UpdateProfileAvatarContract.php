<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Profile\Write;

use Domain\Partner\DataTransferObjects\Profile\UpdateProfileData;
use Illuminate\Http\UploadedFile;

interface UpdateProfileAvatarContract
{
    public function handle(int $partnerId, UploadedFile $avatar): void;
}
