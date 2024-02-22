<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Statistics;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Internal\Statistics\CustomerResource;
use App\Http\Api\Responses\Internal\Statistics\LostOrderResource;
use Domain\Internal\Actions\Statistics\Read\GetCustomerStatisticsContract;
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
final class GetCustomer extends Controller
{
    public function __construct(
        private readonly GetCustomerStatisticsContract $getCustomerStatisticsAction,
    ) {
    }

    /**
     * Get customers - Handle an incoming get customers request from admin.
     */
    public function __invoke(Request $request): mixed
    {
        $numberOfOrders = $this->getCustomerStatisticsAction->handle();
        return new CustomerResource($numberOfOrders);
    }
}
