<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Order;

use App\Models\OrderRoutePermission;
use DateTimeImmutable;
use Domain\CustomerFacing\Enums\OrderStatus;

final readonly class PermissionData
{
    public function __construct(
        public OrderStatus $permission,
        public ?DateTimeImmutable $achievedAt = null,
    ) {
    }

    public static function fromModel(OrderRoutePermission $model): self
    {
        return new self(
            permission: $model->permission,
            achievedAt: $model->achieved_at?->toImmutable(),
        );
    }

    public function toArray(): array {
        return [
            'status' => $this->permission,
            'achieved_at' => $this->achievedAt,
        ];
    }
}
