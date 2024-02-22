<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Driver\Write;

interface DeleteDriverContract
{
    public function handle(int $partnerId, int $driverId): void;
}
