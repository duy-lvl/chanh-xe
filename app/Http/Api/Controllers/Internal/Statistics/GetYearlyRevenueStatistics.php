<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Statistics;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Statistics\GetYearlyRevenueStatisticsRequest;
use App\Http\Api\Responses\Internal\Statistics\YearyRevenueResource;
use Domain\Internal\Actions\Statistics\Read\GetYearlyRevenueStatisticsContract;


/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Statistics
 *
 * @subgroupDescription Internal manage statistics
 */
final class GetYearlyRevenueStatistics extends Controller
{
    public function __construct(
        private readonly GetYearlyRevenueStatisticsContract $getYearlyRevenueStatisticsAction,
    ) {
    }

    /**
     * Get Year revenue - Handle an incoming get Year revenue request from admin.
     */
    public function __invoke(GetYearlyRevenueStatisticsRequest $request): mixed
    {
        $year = $request->getYear();
        $result = $this->getYearlyRevenueStatisticsAction->handle($year);
        return YearyRevenueResource::collection($result);
    }
}
