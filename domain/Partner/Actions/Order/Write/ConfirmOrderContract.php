<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Write;

use Domain\Partner\DataTransferObjects\Order\OrderConfirmationData;

interface ConfirmOrderContract
{
    public function handle(int $partnerId, OrderConfirmationData $confirmData): void;
}
