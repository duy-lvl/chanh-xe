<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Account\Write;

use Domain\Shared\Enums\AccountStatus;

interface UpdateStaffAccountStatusContract
{
    public function handle(int $id, AccountStatus $status): void;
}
