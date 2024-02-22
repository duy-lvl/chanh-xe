<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Order;

use Domain\Partner\DataTransferObjects\Order\OrderData;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use TiMacDonald\JsonApi\JsonApiResource;

final class DoneOrderResource extends JsonApiResource
{
    public function __construct(OrderData $resource)
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
            'code' => Str::upper($this->code),
            'checkpoints' => $this->checkpoints,
            'sender_name' => $this->senderName,
            'sender_phone' => $this->senderPhone,
            'receiver_name' => $this->receiverName,
            'receiver_phone' => $this->receiverPhone,
            'note' => $this->note,
            'package_value' => $this->packageValue,
            'weight' => $this->packageWeight->value(),
            'height' => $this->packageDimensions->height(),
            'length' => $this->packageDimensions->length(),
            'width' => $this->packageDimensions->width(),
            'package_types' => $this->packageTypes,
            'delivery_price' => $this->deliveryPrice,
            'payment_method' => $this->paymentMethod->name,
            'revenue' => $this->revenue,
            'package_image_url' => $this->packageImageUrl,
            'delivered_image_url' => $this->deliveredImageUrl
        ];
    }
}
