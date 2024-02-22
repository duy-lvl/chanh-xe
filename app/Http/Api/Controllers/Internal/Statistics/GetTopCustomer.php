<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Statistics;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Internal\Statistics\TopUserResource;
use Domain\Internal\Actions\Statistics\Read\GetTopUserContract;
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
final class GetTopCustomer extends Controller
{
    public function __construct(
        private readonly GetTopUserContract $getTopUserAction,
    ) {
    }

    /**
     * Get Top users - Handle an incoming get top users request from admin.
     */
    public function __invoke(Request $request, int $numberOfCustomers): mixed
    {
        $customers = $this->getTopUserAction->handle($numberOfCustomers);
        return TopUserResource::collection($customers);
    }
}
