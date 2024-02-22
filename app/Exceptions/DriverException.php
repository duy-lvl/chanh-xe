<?php

namespace App\Exceptions;

use Exception;

class DriverException extends Exception
{
    public static function DeleteFailException(): DriverException
    {
        return new self(message: __('exception.driver.deleteFail'), code: 400);
    }
    public static function UpdateFailException(): DriverException
    {
        return new self(message: __('exception.driver.updateFail'), code: 400);
    }
    public static function UnauthorizedException(): DriverException
    {
        return new self(message: __('exception.driver.unauthorized'), code: 403);
    }
    public static function CreateFailException(): DriverException
    {
        return new self(message: __('exception.driver.createFail'), code: 400);
    }
}
