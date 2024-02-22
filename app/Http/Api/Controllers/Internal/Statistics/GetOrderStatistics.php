<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Statistics;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Internal\Statistics\OrderStatisticsResource;
use Domain\Internal\Actions\Statistics\Read\GetStatisticsOrderContract;
use Request;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Statistics
 *
 * @subgroupDescription Internal manage statistics
 */
final class GetOrderStatistics extends Controller
{
    public function __construct(
        private readonly GetStatisticsOrderContract $getStatisticsOrderAction,
    ) {
    }

    /**
     * Get orders statistics - Handle an incoming get orders statistics request from admin.
     */
    public function __invoke(Request $request): mixed
    {
        $orders = $this->getStatisticsOrderAction->handle();
        return new OrderStatisticsResource($orders);
    }
}
