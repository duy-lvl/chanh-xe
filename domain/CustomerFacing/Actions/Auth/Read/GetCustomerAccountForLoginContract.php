<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Auth\Read;

use App\Models\Customer;
use Domain\CustomerFacing\DataTransferObjects\Auth\LoginData;

interface GetCustomerAccountForLoginContract
{
    public function handle(LoginData $data): Customer;
}
