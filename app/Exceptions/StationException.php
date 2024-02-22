<?php

namespace App\Exceptions;

use Exception;

class StationException extends Exception
{
    public static function StationHasBeenApprovedException(): self
    {
        return new self(code: 400, message: __('exception.station.approved'));
    }
}
