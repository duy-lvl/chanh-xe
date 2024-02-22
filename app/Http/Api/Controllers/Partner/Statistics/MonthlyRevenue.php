<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Statistics;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Statistics\MonthRequest;
use App\Http\Api\Responses\Internal\Statistics\MonthRevenueResource;
use Auth;
use Domain\Partner\Actions\Statistics\Read\GetMonthlyRevenueContract;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Statistics
 *
 * @subgroupDescription Partner manage statistics
 */
final class MonthlyRevenue extends Controller
{
    public function __construct(
        private readonly GetMonthlyRevenueContract $getMonthlyRevenueAction,
    ) {
    }

    /**
     * Get monthly revenue - Handle an incoming get monthly revenue request from partner.
     */
    public function __invoke(MonthRequest $request): mixed
    {
        
        $year = $request->getYear();
        $revenues = $this->getMonthlyRevenueAction->handle($year, Auth::id());
        return MonthRevenueResource::collection($revenues);
    }
}
