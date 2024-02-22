<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Write;

use App\Exceptions\OrderException;
use Domain\CustomerFacing\DataTransferObjects\Order\UpdateOrderData;

interface UpdateOrderContract
{
    /**
     * @throws OrderException
     */
    public function handle(string $code, UpdateOrderData $data): void;
}
