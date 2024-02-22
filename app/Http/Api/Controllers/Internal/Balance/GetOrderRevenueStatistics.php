<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Balance;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Balance\GetOrderRevenueStatisticsRequest;
use App\Http\Api\Responses\Internal\Balance\OrderRevenueStatisticsResource;
use Domain\Internal\Actions\Balance\Read\GetOrderRevenueStatisticsContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Balance
 *
 * @subgroupDescription Admin view application incomes and expenses
 */
final class GetOrderRevenueStatistics extends Controller
{
    public function __construct(
        private readonly GetOrderRevenueStatisticsContract $getOrderRevenueStatisticsAction,
    ) {
    }

    /**
     * Get Transactions - Handle an incoming get transactions from admin.
     */
    public function __invoke(GetOrderRevenueStatisticsRequest $request): mixed
    {
        $year = $request->getYear();

        $transactions = $this->getOrderRevenueStatisticsAction->handle($year);

        return OrderRevenueStatisticsResource::collection($transactions);
    }
}
