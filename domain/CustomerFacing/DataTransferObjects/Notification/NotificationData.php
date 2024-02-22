<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Notification;

use App\Models\Notification;
use DateTimeImmutable;
use Illuminate\Notifications\DatabaseNotification;

final readonly class NotificationData
{
    public function __construct(
        public string $id,
        public string $type,
        public array $data,
        public DateTimeImmutable $createdAt,
        public ?DateTimeImmutable $readAt,
    ) {
    }

    public static function fromModel(DatabaseNotification $model): self
    {
        return new NotificationData(
            id: $model->id,
            type: $model->type,
            data: $model->data,
            readAt: $model->read_at?->toImmutable(),
            createdAt: $model->created_at->toImmutable(),
        );
    }
}
