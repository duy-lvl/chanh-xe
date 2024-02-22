<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Statistics;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Statistics\DateRequest;
use App\Http\Api\Responses\Partner\Statistics\DailyRevenueResource;
use Auth;
use Domain\Partner\Actions\Statistics\Read\GetDailyRevenueContract;
use Illuminate\Support\Facades\Date;
use Request;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Statistics
 *
 * @subgroupDescription Partner manage statistics
 */
final class DailyRevenue extends Controller
{
    public function __construct(
        private readonly GetDailyRevenueContract $getDailyRevenueAction,
    ) {
    }

    /**
     * Get daily revenue - Handle an incoming get month revenue request from partner.
     */
    public function __invoke(DateRequest $request): mixed
    {
        $year = $request->getYear();
        $month = $request->getMonth();
        $revenues = $this->getDailyRevenueAction->handle(year: $year, month: $month, partnerId: Auth::id());
        return DailyRevenueResource::collection($revenues);
    }
}

