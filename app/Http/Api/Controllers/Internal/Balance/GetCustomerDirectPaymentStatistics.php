<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Balance;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Balance\GetCustomerDirectPaymentStatisticsRequest;
use App\Http\Api\Responses\Internal\Balance\CustomerDirectPaymentStatisticsResource;
use Domain\Internal\Actions\Balance\Read\GetCustomerDirectPaymentStatisticsContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Balance
 *
 * @subgroupDescription Admin view application incomes and expenses
 */
final class GetCustomerDirectPaymentStatistics extends Controller
{
    public function __construct(
        private readonly GetCustomerDirectPaymentStatisticsContract $getCustomerDirectPaymentStatisticsAction,
    ) {
    }

    /**
     * Get Transactions - Handle an incoming get transactions from admin.
     */
    public function __invoke(GetCustomerDirectPaymentStatisticsRequest $request): mixed
    {
        $year = $request->getYear();

        $transactions = $this->getCustomerDirectPaymentStatisticsAction->handle($year);

        return CustomerDirectPaymentStatisticsResource::collection($transactions);
    }
}
