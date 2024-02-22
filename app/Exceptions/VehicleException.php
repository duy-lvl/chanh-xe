<?php

namespace App\Exceptions;

use Exception;

class VehicleException extends Exception
{
    public static function DeleteFailException(): VehicleException
    {
        return new self(message: __('exception.vehicle.deleteFail'), code: 400);
    }
    public static function UpdateFailException(): VehicleException
    {
        return new self(message: __('exception.vehicle.updateFail'), code: 400);
    }
    public static function UnauthorizedException(): VehicleException
    {
        return new self(message: __('exception.vehicle.unauthorized'), code: 403);
    }
    public static function CreateFailException(): VehicleException
    {
        return new self(message: __('exception.vehicle.createFail'), code: 400);
    }
}
