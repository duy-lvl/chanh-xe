<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Notification\Read\Implementations;

use App\Models\Customer;
use App\Models\Notification;
use Domain\CustomerFacing\Actions\Notification\Read\GetNotificationContract;
use Domain\CustomerFacing\DataTransferObjects\Notification\NotificationData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\DatabaseNotification;
use Spatie\QueryBuilder\QueryBuilder;

final class GetNotification implements GetNotificationContract
{
    /**
     * @return PaginationContract<NotificationData>
     */
    public function handle(int $customerId, PagingData $pagingData): PaginationContract {
        $customer = Customer::query()->findOrFail($customerId);
        // dd($customer->notifications->sortByDesc('created_at'));
        return QueryBuilder::for(
            subject: $customer->notifications->sortByDesc('created_at')->toQuery()
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
