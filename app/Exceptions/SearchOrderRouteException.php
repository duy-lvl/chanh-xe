<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class SearchOrderRouteException extends Exception
{
    public static function NoRouteFound(): self
    {
        return new self(message: __('exception.searchRoute.noRoute'), code: 404);
    }

    public static function NoStationFound(): self
    {
        return new self(message: __('exception.searchRoute.noStation'), code: 404);
    }
}
