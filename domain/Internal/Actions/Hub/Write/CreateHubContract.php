<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Hub\Write;

use App\Models\Hub;
use Domain\Internal\DataTransferObjects\Hub\NewHubData;

interface CreateHubContract
{
    public function handle(NewHubData $data): Hub;
}
