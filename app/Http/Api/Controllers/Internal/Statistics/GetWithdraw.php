<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Statistics;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Statistics\DateRequest;
use App\Http\Api\Requests\Statistics\MonthRequest;
use App\Http\Api\Responses\Internal\Statistics\DayRevenueResource;
use App\Http\Api\Responses\Internal\Statistics\MonthRevenueResource;
use Carbon\Carbon;
use Domain\Internal\Actions\Statistics\Read\GetMonthRevenueContract;
use Domain\Internal\Actions\Statistics\Read\GetWithdrawContract;
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
final class GetWithdraw extends Controller
{
    public function __construct(
        private readonly GetWithdrawContract $getWithdrawAction,
    ) {
    }

    /**
     * Get withdraw - Handle an incoming get month revenue request from admin.
     */
    public function __invoke(MonthRequest $request): mixed
    {
        $year = $request->getYear();
        
        $result = $this->getWithdrawAction->handle($year);
        return response();
    }
}
