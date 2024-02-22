<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Auth\Read;

use App\Models\Partner;
use Domain\Partner\DataTransferObjects\Auth\LoginData;

interface GetPartnerAccountForLoginContract
{
    public function handle(LoginData $data): Partner;
}
