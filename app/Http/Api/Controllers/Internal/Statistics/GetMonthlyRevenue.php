<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Statistics;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Statistics\MonthRequest;
use App\Http\Api\Requests\Statistics\TimeIntervalRequest;
use App\Http\Api\Responses\Internal\Statistics\MonthRevenueResource;
use Domain\Internal\Actions\Statistics\Read\GetMonthlyRevenueContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;


/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Statistics
 *
 * @subgroupDescription Internal manage statistics
 */
final class GetMonthlyRevenue extends Controller
{
    public function __construct(
        private readonly GetMonthlyRevenueContract $getMonthlyRevenueAction,
    ) {
    }

    /**
     * Get monthly revenue - Handle an incoming get monthly revenue request from admin.
     */
    public function __invoke(MonthRequest $request): mixed
    {
        $year = $request->getYear();
        $revenues = $this->getMonthlyRevenueAction->handle($year);
        return MonthRevenueResource::collection($revenues);
    }
}
