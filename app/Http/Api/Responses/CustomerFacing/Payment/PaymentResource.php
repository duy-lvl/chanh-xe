<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Payment;

use Domain\CustomerFacing\DataTransferObjects\Order\PaymentData;
use Illuminate\Http\Request;
use Str;
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

    public function toAttributes(Request $request): array
    {
        return [
            'payment_method' => $this->paymentMethod,
            'value' => $this->value,
            'vnpay_transaction_code' => $this->vnpayTransactionCode,
            'order_code' => Str::upper($this->orderCode),
            'created_at' => $this->createdAt,
        ];
    }
}
