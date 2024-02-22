<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Price\Write;

use Domain\Internal\DataTransferObjects\Price\BoxSizeData;
use Domain\Internal\DataTransferObjects\Price\NewBoxData;

interface CreateBoxSizeContract
{
    public function handle(NewBoxData $data): BoxSizeData;
}
