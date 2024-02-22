<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Order;

use Domain\CustomerFacing\DataTransferObjects\Order\CompactOrderData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use TiMacDonald\JsonApi\JsonApiResource;

final class CompactOrderResource extends JsonResource
{
    public function __construct(CompactOrderData $resource)
    {
        $this->resource = $resource;
    }

    // public function toId(Request $request): string
    // {
    //     return (string) $this->id;
    // }

    // public function toType(Request $request): string
    // {
    //     return 'order';
    // }

    public function toArray(Request $request): array
    {
        return [
            'code' => Str::upper($this->code),
            'created_at' => $this->createdAt,
            'delivery_price' => $this->deliveryPrice,
            'payment_status' => $this->paymentStatus,
            'receiver_name' => $this->receiverName,
            'latest_order_status' => $this->latestOrderStatus,
            'is_confirmed' => $this->isConfirmed,
            'is_cancelled' => $this->isCancelled,
            'cancelled_at' => $this->cancelledAt,
            'can_be_updated' => !$this->isConfirmed && !$this->isCancelled,
            'can_be_cancelled' => !$this->isConfirmed && !$this->isCancelled,
            'package_image_url' => $this->packageImageUrl,
            'delivered_image_url' => $this->deliveredImageUrl
        ];
    }
}
