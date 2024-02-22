<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Order;

use App\Models\Order;
use DateTimeImmutable;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\CustomerFacing\Enums\PackageType;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\Enums\MassUnit;
use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Weight;
use Illuminate\Support\Collection;
use Facades\Domain\Shared\Services\Image;

final readonly class OrderData
{
    /**
     * @param Collection<PackageType>  $packageTypes
     * @param Collection<CheckpointData> $checkpoints
     */
    public function __construct(
        public int $id,
        public string $code,
        public Collection $checkpoints,
        public string $senderName,
        public string $senderPhone,
        public string $receiverName,
        public string $receiverPhone,
        public ?string $note = null,
        public int $packageValue,
        public bool $isPaid,
        public int $deliveryPrice,
        public PaymentMethod $paymentMethod,
        public Weight $packageWeight,
        public ?Dimensions $packageDimensions = null,
        public Collection $packageTypes,
        public bool $isConfirmed,
        public ?string $cancelledReason = null,
        public ?DateTimeImmutable $cancelledAt = null,
        public OrderStatus $latestOrderStatus,
        public bool $collectOnDelivery,
        public int $revenue,
        public ?string $packageImageUrl,
        public ?string $deliveredImageUrl
    ) {
    }

    /**
     * @param Collection<CheckpointData> $checkpoints
     */
    public static function fromModel(
        Order $model, 
        Collection $checkpoints, 
        int $deliveryPrice,
        int $revenue
    ): self
    {
        $deliveredImageUrl = Image::getFileTemporaryUrl($model->deliver_image_url);
        $packageImageUrl = Image::getFileTemporaryUrl($model->package_image_url);
        
        return new self(
            id: $model->id,
            code: $model->code,
            checkpoints: $checkpoints,
            senderName: $model->sender_name,
            senderPhone: $model->sender_phone,
            receiverName: $model->receiver_name,
            receiverPhone: $model->receiver_phone,
            note: $model->note ?? null,
            packageValue: $model->package_value,
            isPaid: $model->isPaid,
            deliveryPrice: $deliveryPrice,
            packageWeight: new Weight($model->weight, MassUnit::Gram),
            packageDimensions: (null === $model->height && null === $model->width && null === $model->length)
                ? null
                : new Dimensions(
                    width: $model->width,
                    height: $model->height,
                    length: $model->length,
                    unit: LengthUnit::Milimeter,
                ),
            packageTypes: $model->package_types,
            paymentMethod: $model->payment_method,
            isConfirmed: $model->is_confirmed,
            cancelledAt: $model->cancelled_at?->toImmutable(),
            cancelledReason: $model->cancelled_reason??null,
            latestOrderStatus: $model->latest_order_status,
            collectOnDelivery: (bool) $model->collect_on_delivery,
            revenue: $revenue,
            packageImageUrl: $packageImageUrl,
            deliveredImageUrl: $deliveredImageUrl
        );
    }
}
