<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Statistics;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Statistics\DateRequest;
use App\Http\Api\Responses\Internal\Statistics\DayRevenueResource;
use App\Http\Api\Responses\Internal\Statistics\MonthRevenueResource;
use Carbon\Carbon;
use Domain\Internal\Actions\Statistics\Read\GetMonthRevenueContract;
use Illuminate\Http\Request;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Statistics
 *
 * @subgroupDescription Internal manage statistics
 */
final class GetMonthRevenue extends Controller
{
    public function __construct(
        private readonly GetMonthRevenueContract $getMonthRevenueAction,
    ) {
    }

    /**
     * Get month revenue - Handle an incoming get month revenue request from admin.
     */
    public function __invoke(DateRequest $request): mixed
    {
        $year = $request->getYear();
        $month = $request->getMonth();
        $revenues = $this->getMonthRevenueAction->handle($year, $month);
        return DayRevenueResource::collection($revenues);
    }
}
