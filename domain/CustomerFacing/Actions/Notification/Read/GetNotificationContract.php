<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Notification\Read;

use Domain\CustomerFacing\DataTransferObjects\Notification\NotificationData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;

interface GetNotificationContract
{
    /**
     * @return PaginationContract<NotificationData>
     */
    public function handle(int $customerId, PagingData $pagingData): PaginationContract;
}