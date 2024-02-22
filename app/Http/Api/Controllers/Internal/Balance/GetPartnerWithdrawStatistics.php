<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Balance;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Balance\GetPartnerWithdrawStatisticsRequest;
use App\Http\Api\Responses\Internal\Balance\PartnerWithdrawStatisticsResource;
use Domain\Internal\Actions\Balance\Read\GetPartnerWithdrawStatisticsContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Balance
 *
 * @subgroupDescription Admin view application incomes and expenses
 */
final class GetPartnerWithdrawStatistics extends Controller
{
    public function __construct(
        private readonly GetPartnerWithdrawStatisticsContract $getPartnerWithdrawStatisticsAction,
    ) {
    }

    /**
     * Get Transactions - Handle an incoming get transactions from admin.
     */
    public function __invoke(GetPartnerWithdrawStatisticsRequest $request): mixed
    {
        $year = $request->getYear();

        $transactions = $this->getPartnerWithdrawStatisticsAction->handle($year);

        return PartnerWithdrawStatisticsResource::collection($transactions);
    }
}
