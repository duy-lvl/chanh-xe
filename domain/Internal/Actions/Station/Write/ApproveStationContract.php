<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Station\Write;

interface ApproveStationContract
{
    public function handle(int $stationId): bool;
}