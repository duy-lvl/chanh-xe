<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Balance;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Balance\GetPartnerAccountBalanceStatisticsRequest;
use App\Http\Api\Responses\Internal\Balance\PartnerAccountBalanceStatisticsResource;
use Domain\Internal\Actions\Balance\Read\GetPartnerAccountBalanceStatisticsContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Balance
 *
 * @subgroupDescription Admin view application incomes and expenses
 */
final class GetPartnerAccountBalanceStatistics extends Controller
{
    public function __construct(
        private readonly GetPartnerAccountBalanceStatisticsContract $getPartnerAccountBalanceStatisticsAction,
    ) {
    }

    /**
     * Get Transactions - Handle an incoming get transactions from admin.
     */
    public function __invoke(GetPartnerAccountBalanceStatisticsRequest $request): mixed
    {
        $results = $this->getPartnerAccountBalanceStatisticsAction->handle();

        return PartnerAccountBalanceStatisticsResource::make($results);
    }
}
