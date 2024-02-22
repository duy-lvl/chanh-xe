<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Order;

use App\Models\Order;
use DateTimeImmutable;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\CustomerFacing\Enums\PaymentStatus;
use Facades\Domain\Shared\Services\Image;

final readonly class CompactOrderData
{
    public function __construct(
        public int $id,
        public string $code,
        public DateTimeImmutable $createdAt,
        public int $deliveryPrice,
        public PaymentStatus $paymentStatus,
        public OrderStatus $latestOrderStatus,
        public string $receiverName,
        public bool $isConfirmed,
        public bool $isCancelled,
        public ?DateTimeImmutable $cancelledAt = null,
        public ?string $deliveredImageUrl,
        public ?string $packageImageUrl
    ) {
    }

    public static function fromModel(Order $order, OrderStatus $latestOrderStatus): self
    {
        
        $packageImageUrl = Image::getFileTemporaryUrl($order->package_image_url);
        $deliveredImageUrl = Image::getFileTemporaryUrl($order->deliver_image_url);
       
        return new CompactOrderData(
            id: $order->id,
            code: $order->code,
            createdAt: $order->created_at->toImmutable(),
            deliveryPrice: $order->delivery_price,
            latestOrderStatus: $latestOrderStatus,
            paymentStatus: $order->isPaid ? PaymentStatus::Paid : PaymentStatus::NotPaid,
            receiverName: $order->receiver_name,
            isConfirmed: $order->is_confirmed,
            isCancelled: $order->is_cancelled,
            cancelledAt: $order->cancelled_at?->toImmutable(),
            deliveredImageUrl: $deliveredImageUrl,
            packageImageUrl: $packageImageUrl
        );
    }
}
