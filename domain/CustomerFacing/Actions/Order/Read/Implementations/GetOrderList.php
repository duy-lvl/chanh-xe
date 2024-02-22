<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Read\Implementations;

use App\Models\Order;
use Domain\CustomerFacing\Actions\Order\Read\GetOrderListContract;
use Domain\CustomerFacing\DataTransferObjects\Order\CompactOrderData;
use Domain\Shared\Constants\DefaultConstant;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class GetOrderList implements GetOrderListContract
{
    public function handle(int $customerId, ?int $page = null, ?int $perPage = DefaultConstant::PER_PAGE): PaginationContract
    {
        return QueryBuilder::for(
            subject: Order::query()->where('customer_id', $customerId)->orderByDesc('created_at')
        )
            ->allowedFilters(
                filters: [
                    AllowedFilter::scope('created_between'),
                    'code',
                    AllowedFilter::scope('delivery_price_between'),
                    AllowedFilter::scope('payment_status'),
                    AllowedFilter::scope('status'),
                    'receiver_name',
                ]
            )->fastPaginate(
                perPage: $perPage,
                page: $page,
            )->through(
                function (Order $model): CompactOrderData {
                    $model->load('currentCheckpoint.permissions');
                    return CompactOrderData::fromModel($model, $model->latestOrderStatus);
                } 
                    
            );

    }
}
