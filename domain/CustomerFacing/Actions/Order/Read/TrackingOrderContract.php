<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Read;

use Domain\CustomerFacing\DataTransferObjects\Order\OrderTrackingData;

interface TrackingOrderContract
{
    public function handle(string $code, bool $onlyAchievedFlag = true): ?OrderTrackingData;
}
