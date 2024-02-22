<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Auth\Read;

use App\Models\Staff;
use Domain\Internal\DataTransferObjects\Auth\LoginData;

interface GetStaffAccountForLoginContract
{
    public function handle(LoginData $data): Staff;
}
