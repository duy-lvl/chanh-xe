<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read;

use Domain\Internal\DataTransferObjects\Statistics\TopPartnerData;
use Illuminate\Support\Collection;

interface GetTopPartnerContract
{
    /**
     * @return Collection<TopPartnerData>
     */
    public function handle(int $numberOfPartner = 10): Collection;
}
