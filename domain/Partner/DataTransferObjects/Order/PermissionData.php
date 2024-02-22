<?php

declare(strict_types=1);

namespace Domain\Partner\DataTransferObjects\Order;

use App\Models\OrderRoutePermission;
use DateTimeImmutable;
use Domain\CustomerFacing\Enums\OrderStatus;

final readonly class PermissionData
{
    public function __construct(
        public OrderStatus $permission,
        public int $permissionNumber,
        public ?DateTimeImmutable $achievedAt = null,
        public bool $canBeAchieved
    ) {
    }

    public static function fromModel(OrderRoutePermission $model, bool $canBeAchieved): self
    {
        return new self(
            permission: $model->permission,
            permissionNumber: $model->permission_number,
            achievedAt: $model->achieved_at?->toImmutable(),
            canBeAchieved: $canBeAchieved
        );
    }

    public function toArray(): array {
        return [
            'permission' => $this->permission,
            'permission_name' => $this->permission->name,
            'permission_number' => $this->permissionNumber,
            'achieved_at' => $this->achievedAt,
            'can_be_achieved' => $this->canBeAchieved
        ];
    }
}
