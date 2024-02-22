<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Payment\Read\Implementations;

use App\Models\Customer;
use App\Models\Payment;
use Domain\CustomerFacing\Actions\Payment\Read\GetPaymentHistoryContract;
use Domain\CustomerFacing\DataTransferObjects\Order\PaymentData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\QueryBuilder;
use Str;

final class GetPaymentHistory implements GetPaymentHistoryContract
{
    /**
     * @return PaginationContract<PaymentData>
     */
    public function handle(int $customerId, PagingData $pagingData): PaginationContract {
        $customer = Customer::query()->findOrFail($customerId);
        return QueryBuilder::for(
            subject: $customer->payments()->with('order')->orderByDesc('payments.created_at')
        )
            ->allowedFilters(
                filters: [
                ]
            )->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            )->through(
                function (Payment $model): PaymentData {                    
                    return PaymentData::fromModel(payment: $model, orderCode: $model->order->code);
                } 
                    
            );

    }
}
