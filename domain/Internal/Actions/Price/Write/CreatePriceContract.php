<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Price\Write;

use Domain\Internal\DataTransferObjects\Price\NewPriceData;

interface CreatePriceContract
{
    public function handle(int $boxSizeId, NewPriceData $data): bool;
}
