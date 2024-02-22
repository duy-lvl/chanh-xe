<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Order;

use App\Models\Order;
use DateTimeImmutable;
use Domain\CustomerFacing\Enums\PackageType;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\Enums\MassUnit;
use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Weight;
use Illuminate\Support\Collection;
use Facades\Domain\Shared\Services\Image;
final readonly class DetailedOrderData
{
    /**
     * @param  Collection<PackageType>  $packageTypes
     * @param  Collection<PaymentData>  $payments
     * @param  Collection<CheckpointData> $checkpoints
     * */
    public function __construct(
        public int $id,
        public ?int $customerId = null,
        public StationData $startStation,
        public StationData $endStation,
        public Collection $checkpoints,
        public string $code,
        public string $senderName,
        public string $senderPhone,
        public ?string $senderEmail = null,
        public string $receiverName,
        public string $receiverPhone,
        public ?string $receiverEmail = null,
        public ?string $note = null,
        public ?int $packageValue = null,
        public int $deliveryPrice,
        public Weight $weight,
        public Dimensions $dimensions,
        public bool $collectOnDelivery,
        public Collection $packageTypes,
        public bool $isPaid,
        public ?Collection $payments = null,
        public PaymentMethod $paymentMethod,
        public bool $isConfirmed,
        public bool $isCancelled,
        public ?DateTimeImmutable $cancelledAt = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $confirmedAt = null,
        public ?string $cancelledReason = null,
        public ?string $packageImageUrl,
        public ?string $deliveredImageUrl,
        public ?string $receiveToken,
    ) {
    }

    /**
     * @param  null|Collection<PaymentData>  $paymentData
     * @param  null|Collection<CheckpointData> $checkpoints
     * */
    public static function fromModel(
        Order $model,
        StationData $startStation,
        StationData $endStation,
        ?Collection $checkpoints = null,
        ?Collection $paymentData = null
    ): self {
        $packageImageUrl = Image::getFileTemporaryUrl($model->package_image_url);
        $deliveredImageUrl = Image::getFileTemporaryUrl($model->deliver_image_url);
       
        return new DetailedOrderData(
            id: $model->id,
            customerId: $model->customer_id,
            checkpoints: $checkpoints ?? null,
            code: $model->code,
            senderName: $model->sender_name,
            senderPhone: $model->sender_phone,
            senderEmail: $model->sender_email ?? null,
            receiverName: $model->receiver_name,
            receiverPhone: $model->receiver_phone,
            receiverEmail: $model->receiver_email ?? null,
            note: $model->note,
            packageValue: $model->package_value,
            deliveryPrice: $model->delivery_price,
            weight: new Weight($model->weight, MassUnit::Gram),
            dimensions: new Dimensions(width: $model->width, height: $model->height, length: $model->length, unit: LengthUnit::Milimeter),
            collectOnDelivery: (bool) $model->collect_on_delivery,
            packageTypes: $model->package_types,
            isPaid: $model->is_paid,
            payments: $paymentData,
            paymentMethod: $model->payment_method,
            isConfirmed: (bool) $model->is_confirmed,
            startStation: $startStation,
            endStation: $endStation,
            isCancelled: (bool) $model->is_cancelled,
            cancelledAt: $model->cancelled_at?->toImmutable(),
            createdAt: $model->created_at?->toImmutable(),
            confirmedAt: $model->confirmed_at?->toImmutable(),
            cancelledReason: $model->cancelled_reason??null,
            packageImageUrl: $packageImageUrl,
            deliveredImageUrl: $deliveredImageUrl,
            receiveToken: $model->receive_token,
        );
    }
}
