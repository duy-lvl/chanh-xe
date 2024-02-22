<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Price\Read;


interface GetPriceContract
{
    /**
     * @return int
     */
    public function handle(float $length, float $width, float $height, float $weight, float $distance): int;
}
