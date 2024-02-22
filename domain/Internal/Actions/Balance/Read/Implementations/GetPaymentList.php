<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Balance\Read\Implementations;

use App\Models\Payment;
use Domain\Internal\Actions\Balance\Read\GetPaymentListContract;
use Domain\Internal\DataTransferObjects\Balance\PaymentData;
use Domain\Partner\Services\CalculateRevenue;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\QueryBuilder;

final class GetPaymentList implements GetPaymentListContract
{
    public function __construct(
        private readonly CalculateRevenue $calculateRevenueService
    ) {}
    /**
     * @return PaginationContract<PaymentData>
     */
    public function handle(PagingData $pagingData): PaginationContract
    {
        $query = Payment::query()->with(
                [
                    'order.customer',
                    'order.firstCheckpoint.checkpoint',
                    'order.lastCheckpoint.checkpoint'
                ]
            )
            ->orderByDesc('created_at');

        $paymentPaginatedCollection = QueryBuilder::for(subject: $query)
            ->allowedFilters(
                filters: [
                ]
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
        );

        return $paymentPaginatedCollection
            ->through(
                callback: function (Payment $payment) {
                    $order = $payment->order;
                    $firstPartnerId = $order->firstCheckpoint->checkpoint->partner_id;
                    $secondPartnerId = $order->lastCheckpoint->checkpoint->partner_id;
                    $firstPartnerRevenue = $this->calculateRevenueService->calculateRevenue($order, $firstPartnerId);
                    $secondPartnerRevenue = $this->calculateRevenueService->calculateRevenue($order, $secondPartnerId);
                    if ($firstPartnerRevenue === $secondPartnerRevenue) {
                        $secondPartnerRevenue = 0;
                    }
                    return PaymentData::fromModel(
                        model: $payment, 
                        orderCode: $payment->order->code, 
                        customer: $payment->order->customer,
                        firstPartnerRevenue: $firstPartnerRevenue,
                        secondPartnerRevenue: $secondPartnerRevenue
                    );
                } 
            );
    }
}
