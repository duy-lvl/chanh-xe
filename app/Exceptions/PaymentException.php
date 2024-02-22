<?php

namespace App\Exceptions;

use Exception;

class PaymentException extends Exception
{
    public static function OrderHadBeenPaidException(): PaymentException
    {
        return new self(message: __('exception.payment.paid'), code: 400);
    }

    public static function OrderNotFoundException(): self
    {
        return new self(message: __('exception.payment.orderNotFound'), code: 404);
    }

    public static function InvalidSignatureException(): self
    {
        return new self(message: __('exception.payment.invalidSignature'), code: 400);
    }

    public static function InvalidAmountException(): self
    {
        return new self(message: __('exception.payment.invalidAmount'), code: 400);
    }

    public static function TransactionFailedException(): self
    {
        return new self(message: __('exception.payment.transactionFailed'), code: 400);
    }

    public static function ConflictPaymentMethodException(): self
    {
        return new self(message: __('exception.payment.paymentMethodConflicted'), code: 400);
    }

    public static function InvalidOrderStatusException(): self
    {
        return new self(message: __('exception.payment.invalidOrderStatus'), code: 400);
    }

    public static function OrderNotConfirmedException(): self
    {
        return new self(message: __('exception.payment.orderNotConfirmed'), code: 400);
    }

    public static function OrderHasBeenCancelledException(): self
    {
        return new self(message: __('exception.payment.orderCancelled'), code: 400);
    }
}
