<?php

namespace App\Exceptions;

use Exception;

class ProfileException extends Exception
{
    public static function UpdateFailException(): self
    {
        return new self(message: __('exception.profile.updateFailed'), code: 400);
    }

    public static function PhoneNumberExistedException(): self
    {
        return new self(message: __('exception.profile.phoneNumberExisted'), code: 400);
    }

    public static function EmailExistedException(): self
    {
        return new self(message: __('exception.profile.emailExisted'), code: 400);
    }
}
