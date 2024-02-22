<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Partner\Read;

use Domain\CustomerFacing\DataTransferObjects\Partner\PartnerData;

interface GetPartnerDetailContract
{
    public function handle(int $partnerId): PartnerData;
}
