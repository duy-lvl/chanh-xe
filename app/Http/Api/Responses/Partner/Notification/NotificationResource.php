<?php

declare(strict_types=1);

namespace App\Http\Api\Responses\Partner\Notification;

use Domain\Partner\DataTransferObjects\Notification\NotificationData;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

final class NotificationResource extends JsonApiResource
{
    public function __construct(NotificationData $resource)
    {
        $this->resource = $resource;
    }

    public function toId(Request $request): string
    {
        return $this->id;
    }

    public function toType(Request $request): string
    {
        return 'notification';
    }

    public function toAttributes(Request $request): array
    {
        return [
            'type' => $this->type,
            'data' => $this->data,
            'read_at' => $this->readAt,
            'created_at' => $this->createdAt,
        ];
    }
}
