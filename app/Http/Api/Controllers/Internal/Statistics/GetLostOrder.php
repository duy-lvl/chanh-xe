<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Statistics;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Internal\Statistics\LostOrderResource;
use Domain\Internal\Actions\Statistics\Read\GetLostOrdersStatisticsContract;
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
final class GetLostOrder extends Controller
{
    public function __construct(
        private readonly GetLostOrdersStatisticsContract $getStatisticsOrderAction,
    ) {
    }

    /**
     * Get lost orders - Handle an incoming get lost orders request from admin.
     */
    public function __invoke(Request $request): mixed
    {
        $numberOfOrders = $this->getStatisticsOrderAction->handle();
        return new LostOrderResource($numberOfOrders);
    }
}
