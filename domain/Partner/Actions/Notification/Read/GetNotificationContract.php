<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Notification\Read;

use Domain\Partner\DataTransferObjects\Notification\NotificationData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetNotificationContract
{
    /**
     * @return PaginationContract<NotificationData>
     */
    public function handle(int $partnerId, PagingData $pagingData): PaginationContract;
}