<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Hub\Read;

use Domain\Internal\DataTransferObjects\Hub\HubData;

interface GetHubByIdContract
{
    /**
     * @param int $id
     * @return null|HubData
     */
    public function handle(int $id): ?HubData;
}
