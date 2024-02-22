<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Account\Write;

use Domain\Internal\DataTransferObjects\Account\NewStaffAccountData;
use Domain\Internal\DataTransferObjects\Account\StaffAccountData;

interface CreateStaffAccountContract
{
    public function handle(NewStaffAccountData $data): StaffAccountData;
}
