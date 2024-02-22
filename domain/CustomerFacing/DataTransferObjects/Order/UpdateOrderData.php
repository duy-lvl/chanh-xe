<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Order;

use Domain\CustomerFacing\Enums\PackageType;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\Shared\ValueObjects\Dimensions;
use Domain\Shared\ValueObjects\Weight;
use Illuminate\Support\Collection;

final readonly class UpdateOrderData
{
    /**
     * @param  Collection<PackageType>  $packageTypes
     */
    public function __construct(
        public int $customerId,
        public string $senderName,
        public string $senderPhone,
        public ?string $senderEmail,
        public string $receiverName,
        public string $receiverPhone,
        public ?string $receiverEmail,
        // public ?string $note,
        // public ?int $packageValue,
        // public Weight $weight,
        // public Dimensions $dimensions,
        // public PaymentMethod $paymentMethod,
        // public bool $collectOnDelivery,
    ) {
    }
}
