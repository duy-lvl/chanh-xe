<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Account\Write;

use Domain\Internal\DataTransferObjects\Account\NewPartnerAccountData;
use Domain\Internal\DataTransferObjects\Account\PartnerAccountData;

interface CreatePartnerAccountContract
{
    public function handle(NewPartnerAccountData $data): PartnerAccountData;
}
