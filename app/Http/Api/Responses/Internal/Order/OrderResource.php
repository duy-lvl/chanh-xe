<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Internal\Order;

use Domain\Internal\DataTransferObjects\Order\OrderData;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use TiMacDonald\JsonApi\JsonApiResource;

final class OrderResource extends JsonApiResource
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
            'is_confirmed' => $this->isConfirmed,
            'is_lost' => $this->isLost,
            'lost_blame_id' => $this->lostBlameId,
            'lost_blame_type' => $this->lostBlameType,
            'revenue' => $this->revenue,
            'delivery_price' => $this->deliveryPrice,
            'first_partner_revenue' => $this->firstPartnerRevenue,
            'second_partner_revenue' => $this->secondPartnerRevenue,
            'package_image_url' => $this->packageImageUrl,
            'delivered_image_url' => $this->deliveredImageUrl,
            'start_partner_id' => $this->startPartnerId,
            'end_partner_id' => $this->endPartnerId
        ];
        // return [
        //     'code' => Str::upper($this->code),
        //     'partner_name' => $this->partnerName,
        //     'sender_name' => $this->senderName,
        //     'sender_phone' => $this->senderPhone,
        //     'receiver_name' => $this->receiverName,
        //     'receiver_phone' => $this->receiverPhone,
        //     'current_status' => $this->currentStatus,
        //     'note' => $this->note,
        //     'package_value' => $this->packageValue,
        //     'weight' => $this->packageWeight->value(),
        //     'height' => $this->packageDimensions->height(),
        //     'length' => $this->packageDimensions->length(),
        //     'width' => $this->packageDimensions->width(),
        //     'package_types' => $this->packageTypes,
        //     'is_paid' => $this->isPaid,
        // ];
    }
}
