<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Order;

use App\Models\Payment;
use DateTimeImmutable;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\CustomerFacing\Enums\PaymentStatus;

final readonly class PaymentData
{
    public function __construct(
        public int $id,
        public PaymentMethod $paymentMethod,
        public int $value,
        public ?string $vnpayTransactionCode = null,
        public string $orderCode,
        public DateTimeImmutable $createdAt,
    ) {
    }

    public static function fromModel(Payment $payment, string $orderCode): self
    {
        return new PaymentData(
            id: $payment->id,
            paymentMethod: $payment->payment_method,
            value: $payment->value,
            vnpayTransactionCode: $payment->vnpay_transaction_code ?? null,
            orderCode: $orderCode,
            createdAt: $payment->created_at->toImmutable(),
        );
    }
}
