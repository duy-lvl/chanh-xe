<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Driver\Write;

use Domain\Partner\DataTransferObjects\Driver\UpdateDriverData;

interface UpdateDriverContract
{
    public function handle(int $partnerId, UpdateDriverData $data): void;
}
