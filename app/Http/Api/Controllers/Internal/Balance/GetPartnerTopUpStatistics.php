<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Balance;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Balance\GetPartnerTopUpStatisticsRequest;
use App\Http\Api\Responses\Internal\Balance\PartnerTopUpStatisticsResource;
use Domain\Internal\Actions\Balance\Read\GetPartnerTopUpStatisticsContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Balance
 *
 * @subgroupDescription Admin view application incomes and expenses
 */
final class GetPartnerTopUpStatistics extends Controller
{
    public function __construct(
        private readonly GetPartnerTopUpStatisticsContract $getPartnerTopUpStatisticsAction,
    ) {
    }

    /**
     * Get Transactions - Handle an incoming get transactions from admin.
     */
    public function __invoke(GetPartnerTopUpStatisticsRequest $request): mixed
    {
        $year = $request->getYear();

        $transactions = $this->getPartnerTopUpStatisticsAction->handle($year);

        return PartnerTopUpStatisticsResource::collection($transactions);
    }
}
