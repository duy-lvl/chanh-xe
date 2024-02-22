<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Hub\Read\Implementations;

use App\Models\Hub;
use Domain\Internal\Actions\Hub\Read\GetHubByIdContract;
use Domain\Internal\DataTransferObjects\Hub\HubData;

final class GetHubById implements GetHubByIdContract
{
    public function handle(int $id): ?HubData
    {
        $hub = Hub::query()->where('id', $id)->first();
        if (is_null($hub)) {
            return null;
        }
        else {
            return HubData::fromModel($hub);
        }
    }
}
