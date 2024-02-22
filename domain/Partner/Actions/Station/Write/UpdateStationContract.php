<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Station\Write;

use App\Models\Station;
use Domain\Partner\DataTransferObjects\Station\UpdatableStationData;

interface UpdateStationContract
{
    public function handle(UpdatableStationData $data): Station;
}
