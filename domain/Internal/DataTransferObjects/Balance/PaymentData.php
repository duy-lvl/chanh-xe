<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Balance;

use App\Models\Customer;

use App\Models\Payment;
use DateTimeImmutable;
use Domain\CustomerFacing\Enums\PaymentMethod;

final readonly class PaymentData
{
    public function __construct(
        public int $id,
        public PaymentMethod $paymentMethod,
        public int $value,
        public string $orderCode,
        public ?string $vnpayTransactionCode = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?int $customerId = null,
        public ?string $customerName = null,
        public int $revenue,
        public int $firstPartnerRevenue,
        public int $secondPartnerRevenue,
    ) {
    }

    public static function fromModel(
        Payment $model, 
        string $orderCode, 
        ?Customer $customer = null,
        int $firstPartnerRevenue,
        int $secondPartnerRevenue,
    ): self
    {
        $revenue = (int)$model->value - $firstPartnerRevenue - $secondPartnerRevenue;
        return new PaymentData(
            id: $model->id,
            paymentMethod: $model->payment_method,
            value: $model->value,
            orderCode: $orderCode,
            vnpayTransactionCode: $model->vnpay_transaction_code ?? null,
            createdAt: $model->created_at?->toImmutable(),
            customerId: $customer?->id,
            customerName: $customer?->name,
            revenue: $revenue,
            firstPartnerRevenue: $firstPartnerRevenue,
            secondPartnerRevenue: $secondPartnerRevenue,

        );
    }
}
