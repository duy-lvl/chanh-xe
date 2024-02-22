<?php

namespace App\Exceptions;

use Exception;

class OrderException extends Exception
{
    public static function OrderCodeNotFoundException(string $code): OrderException
    {
        return new self(message: __('exception.order.notFound', ['value' => $code]), code: 404);
    }

    public static function InvalidOrderStatusException(): OrderException
    {
        return new self(message: __('exception.order.invalidStatus'), code: 400);
    }

    public static function OrderNotBelongToPartnerException(): OrderException
    {
        return new self(message: __('exception.order.unauthorized'), code:403);
    }

    public static function OrderNotPaidException(): OrderException
    {
        return new self(message: __('exception.order.notPaid'), code:400);
    }

    public static function UpdateStatusFailedException(): OrderException
    {
        return new self(message: __('exception.order.updateStatusFailed'), code:400);
    }

    public static function ConfirmFailedException(): OrderException
    {
        return new self(message: __('exception.order.confirmFailed'), code:400);
    }

    public static function OrderNotBelongToStaffException(): OrderException
    {
        return new self(message: __('exception.order.unauthorized'), code:403);
    }

    public static function OrderHasBeenConfirmedException(): OrderException
    {
        return new self(message: __('exception.order.confirmed'), code:400);
    }

    public static function OrderHasNotBeenConfirmedException(): OrderException
    {
        return new self(message: __('exception.order.notConfirmed'), code:400);
    }

    public static function OrderHasBeenCancelledException(): OrderException
    {
        return new self(message: __('exception.order.cancelled'), code:400);
    }

    public static function OrderIdentifierIsRequiredException(): OrderException
    {
        return new self(message: __('exception.order.missingIdentifier'), code:400);
    }

    public static function UpdateOrderFailedException(): OrderException
    {
        return new self(message: __('exception.order.updateFailed'), code: 400);
    }

    public static function OrderNotBelongToCustomerException(): OrderException
    {
        return new self(message: __('exception.order.unauthorized'), code:403);
    }

    public static function PaymentMethodNotSupportedException(): OrderException
    {
        return new self(message: __('exception.order.unsupportedPaymentMethod'), code:400);
    }

    public static function OrderHasBeenLostException(): OrderException
    {
        return new self(message: __('exception.order.lost'), code: 400);
    }

    public static function OrderIsNotAtHub(): OrderException
    {
        return new self(message: __('exception.order.orderNotAtHub'), code: 400);
    }

    public static function UpdateCheckpointFailed(): OrderException
    {
        return new self(message: __('exception.order.updateCheckpointFailed'), code: 400);
    }

    public static function DriverNotBelongToPartner(): OrderException
    {
        return new self(message: __('exception.order.driverNotBelongToPartner'), code: 400);
    }

    public static function VehicleNotBelongToPartner(): OrderException
    {
        return new self(message: __('exception.order.vehicleNotBelongToPartner'), code: 400);
    }

    public static function ReceiveTokenNotMatch(): OrderException
    {
        return new self(message: __('exception.order.receiveTokenNotMatch'), code: 400);
    }
}
