<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Balance;

use Domain\Internal\DataTransferObjects\Balance\PaymentData;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use TiMacDonald\JsonApi\JsonApiResource;

final class PaymentResource extends JsonApiResource
{
    public function __construct(PaymentData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'payment';
    }

    public function toAttributes(Request $request): array {
        return [
            'payment_method' => $this->paymentMethod->name,
            'value' => $this->value,
            'order_code' => Str::upper($this->orderCode),
            'vnpay_transaction_code' => $this->vnpayTransactionCode,
            'created_at' => $this->createdAt,
            'customer_id' => $this->customerId,
            'customer_name' => $this->customerName,
            'revenue' => $this->revenue,
            'start_partner_revenue' => $this->firstPartnerRevenue,
            'end_partner_revenue' => $this->secondPartnerRevenue
        ];
    }
}
