<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\CustomerFacing\Order;

use App\Http\Api\Responses\CustomerFacing\Payment\PaymentResource;
use Domain\CustomerFacing\DataTransferObjects\Order\DetailedOrderData;
use Domain\CustomerFacing\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use TiMacDonald\JsonApi\JsonApiResource;

final class OrderDetailResource extends JsonApiResource
{
    public function __construct(DetailedOrderData $resource)
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
        $checkpoints = collect();
        foreach ($this->checkpoints as $checkpoint) {
            foreach($checkpoint->permissions as $permission) {
                if ($permission->achievedAt === null) {
                    break;
                }
                $checkpoints->push(
                    [
                        'name' => $checkpoint->name,
                        'address' => $checkpoint->address,
                        'status' => $permission->permission,
                        'achieved_at' => $permission->achievedAt
                    ]
                );
            }
        }
        if ($this->confirmedAt !== null) {
            $checkpoints->prepend([
                'name' => null,
                'address' => null,
                'status' => OrderStatus::Confirmed,
                'achieved_at' => $this->confirmedAt
            ]);
        }
        $checkpoints->prepend([
            'name' => null,
            'address' => null,
            'status' => OrderStatus::Created,
            'achieved_at' => $this->createdAt
        ]);

        if ($this->isCancelled) {
            $checkpoints->push([
                'name' => null,
                'address' => null,
                'status' => 5,
                'achieved_at' => $this->cancelledAt
            ]);
        }

        return [
            'start_station' => $this->startStation,
            'end_station' => $this->endStation,
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
            'weight' => $this->weight->value(),
            'height' => $this->dimensions->height(),
            'length' => $this->dimensions->length(),
            'width' => $this->dimensions->width(),
            'collect_on_delivery' => $this->collectOnDelivery,
            'payment_method' => $this->paymentMethod,
            'package_types' => $this->packageTypes,
            'is_paid' => $this->isPaid,
            'is_confirmed' => $this->isConfirmed,
            'is_cancelled' => $this->isCancelled,
            'cancelled_at' => $this->cancelledAt,
            'checkpoints' => $checkpoints,
            'cancelled_reason' => $this->cancelledReason,
            'package_image_url' => $this->packageImageUrl,
            'delivered_image_url' => $this->deliveredImageUrl,
            'receive_token' => $this->receiveToken,
        ];
    }

    public function toRelationships(Request $request)
    {
        return [
            'payments' => fn () => PaymentResource::collection($this->payments ?? new Collection()),
        ];
    }
}
