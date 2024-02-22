<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Profile\Write;

use Domain\CustomerFacing\DataTransferObjects\Profile\UpdateProfileData;

interface UpdateProfileContract
{
    public function handle(UpdateProfileData $data): void;
}
