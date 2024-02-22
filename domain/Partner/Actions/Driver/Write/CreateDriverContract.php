<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Driver\Write;

use Domain\Partner\DataTransferObjects\Driver\NewDriverData;

interface CreateDriverContract
{
    public function handle(NewDriverData $data): void;
}
