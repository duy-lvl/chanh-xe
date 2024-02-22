<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Profile\Write;

use Domain\Partner\DataTransferObjects\Profile\UpdateProfileData;

interface DeleteProfileAvatarContract
{
    public function handle(int $partnerId): void;
}
