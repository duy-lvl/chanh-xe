<?php

namespace App\Exceptions;

use Domain\Shared\Enums\AccountStatus;
use Exception;

class AccountException extends Exception
{
    public static function SameStatusException(AccountStatus $status): AccountException
    {
        return new self(message: __('exception.account.sameStatus'), code: 400);
    }

    public static function UpdateFailedException(): AccountException
    {
        return new self(message: __('exception.account.updateFailed'), code: 400);
    }

    public static function AccountInactiveException(): AccountException
    {
        return new self(message: __('exception.account.inactive'), code: 400);
    }
}
