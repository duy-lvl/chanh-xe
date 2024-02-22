<?php

namespace App\Exceptions;

use Exception;

class TransactionException extends Exception
{
    public static function InsufficentBalanceException(): self
    {
        return new self(message: __('exception.transaction.insufficentBalance'), code: 400);
    }
    public static function TransactionHasBeenProceeded(): self{
        return new self(message: __('exception.transaction.proceeded'), code: 400);
    }

    public static function Unauthorize(): self{
        return new self(message: __('exception.transaction.unauthorized'), code: 403);
    }
}
