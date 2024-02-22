<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class PriceCalculationException extends Exception
{
    public static function UnavailableBoxSizeException(): self
    {
        return new self(message: __('exception.priceCalculation.unavailable'), code: 400);
    }

    public static function UnavailablePriceTableException(): self
    {
        return new self(message: __('exception.priceCalculation.unavailable'), code: 400);
    }

    public static function UnavailablePriceItemException(): self
    {
        return new self(message: __('exception.priceCalculation.unavailable'), code: 400);
    }
}
