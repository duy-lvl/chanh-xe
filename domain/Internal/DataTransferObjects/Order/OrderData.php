<?php

declare(strict_types=1);

namespace Domain\Internal\DataTransferObjects\Order;

use App\Models\Order;
use Domain\CustomerFacing\Enums\OrderStatus;
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
     * @param Collection<\Domain\Partner\DataTransferObjects\Order\CheckpointData> $checkpoints
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
        public Weight $packageWeight,
        public ?Dimensions $packageDimensions = null,
        public Collection $packageTypes,
        public bool $isConfirmed,
        public ?int $deliveryPrice = 0,
        public bool $isLost,
        public ?int $lostBlameId =  null,
        public ?string $lostBlameType = null,
        public int $revenue,
        public int $firstPartnerRevenue,
        public int $secondPartnerRevenue,
        public ?string $packageImageUrl,
        public ?string $deliveredImageUrl,
        public ?int $startPartnerId,
        public ?int $endPartnerId,
    ) {
    }

    /**
     * @param Collection<\Domain\Partner\DataTransferObjects\Order\CheckpointData> $checkpoints
     */
    public static function fromModel(
        Order $model,
        Collection $checkpoints,
        ?int $deliveryPrice = 0,
        bool $isPassThroughHub,
        int $firstPartnerRevenue,
        int $secondPartnerRevenue,
        ?int $startPartnerId = null,
        ?int $endPartnerId = null
    ): self
    {
        // $revenue = (int) ($isPassThroughHub ? round((int) $model->delivery_price * 15.0 / 100) : round((int) $model->delivery_price * 5.0 / 100));
        $revenue = $model->delivery_price - $firstPartnerRevenue - $secondPartnerRevenue;
        $packageImageUrl = Image::getFileTemporaryUrl($model->package_image_url);
        $deliveredImageUrl = Image::getFileTemporaryUrl($model->deliver_image_url);
      
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
            isConfirmed: (bool)$model->is_confirmed,
            deliveryPrice: $deliveryPrice,
            isLost: $model->is_lost ?? false,
            lostBlameId: $model->lost_incharge_id,
            lostBlameType: $model->lost_incharge_type,
            revenue: $revenue,
            firstPartnerRevenue: $firstPartnerRevenue,
            secondPartnerRevenue: $secondPartnerRevenue,
            packageImageUrl: $packageImageUrl,
            deliveredImageUrl: $deliveredImageUrl,
            startPartnerId: $startPartnerId,
            endPartnerId: $endPartnerId
        );
    }
}
