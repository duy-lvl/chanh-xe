<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Auth\Write;

use App\Models\Customer;
use Domain\CustomerFacing\DataTransferObjects\Auth\NewCustomerData;

interface RegisterNewCustomerAccountContract
{
    public function handle(NewCustomerData $userData): Customer;
}
