<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Payment\Write;

use Domain\CustomerFacing\DataTransferObjects\Payment\VnPayReturnData;

interface ProceedPaymentContract
{
    public function handle(VnPayReturnData $vnPayReturnData): mixed;
}