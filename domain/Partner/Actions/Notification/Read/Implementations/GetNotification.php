<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Notification\Read\Implementations;

use App\Models\Partner;
use Domain\Partner\Actions\Notification\Read\GetNotificationContract;
use Domain\Partner\DataTransferObjects\Notification\NotificationData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Illuminate\Notifications\DatabaseNotification;
use Spatie\QueryBuilder\QueryBuilder;

final class GetNotification implements GetNotificationContract
{
    /**
     * @return PaginationContract<NotificationData>
     */
    public function handle(int $partnerId, PagingData $pagingData): PaginationContract {
        $partner = Partner::query()->findOrFail($partnerId);
        return QueryBuilder::for(
            subject: $partner->notifications->sortByDesc('created_at')->toQuery()
        )
            ->allowedFilters(
                filters: [
                ]
            )->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            )->through(
                function (DatabaseNotification $model): NotificationData {                    
                    return NotificationData::fromModel($model);
                } 
                    
            );

    }
}
