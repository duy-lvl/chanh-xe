<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Order;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use Domain\Partner\DataTransferObjects\Order\StartingOrderData;

final class ConfirmOrderResource extends JsonApiResource
{
    public function __construct(StartingOrderData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return (string) $this->id;
    }

    public function toType(Request $request): string
    {
        return 'order';
    }

    public function toAttributes(Request $request): array
    {
        return [
            'start_place' => $this->startPlace,
            'end_place' => $this->endPlace,
            'code' => Str::upper($this->code),
            'sender_name' => $this->senderName,
            'sender_phone' => $this->senderPhone,
            'sender_email' => $this->senderEmail,
            'receiver_name' => $this->receiverName,
            'receiver_phone' => $this->receiverPhone,
            'receiver_email' => $this->receiverEmail,
            'note' => $this->note,
            'package_value' => $this->packageValue,
            'delivery_price' => $this->deliveryPrice,
            'weight' => $this->weight,
            'height' => $this->height,
            'length' => $this->length,
            'width' => $this->width,
            'payment' => [
                'payment_method' => $this->payment->paymentMethod,
                'value' => $this->payment->value,
                'vnpay_transaction_code' => $this->payment->vnpayTransactionCode,
                'status' => $this->payment->status,
            ],
            'package_type' => $this->packageType->map(fn ($type) => (int) $type),
            'collect_on_delivery' => $this->collectOnDelivery
        ];
    }
}
