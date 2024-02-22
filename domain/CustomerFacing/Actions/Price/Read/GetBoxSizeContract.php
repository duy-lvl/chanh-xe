<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Price\Read;

use Domain\CustomerFacing\DataTransferObjects\Price\BoxSizeData;
use Illuminate\Support\Collection;

interface GetBoxSizeContract
{
    /**
     * @return Collection<BoxSizeData>
     */
    public function handle(): Collection;
}
