<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Profile\Write;

use Domain\Partner\DataTransferObjects\Profile\UpdateProfileData;

interface UpdateProfileContract
{
    public function handle(int $partnerId, UpdateProfileData $data): void;
}
