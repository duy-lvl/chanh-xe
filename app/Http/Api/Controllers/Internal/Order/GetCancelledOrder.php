<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Order\GetOrderRequest;
use App\Http\Api\Responses\Internal\Order\OrderResource;
use Domain\Internal\Actions\Order\Read\GetCancelledOrdersContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Order
 *
 * @subgroupDescription Order interactions
 */
final class GetCancelledOrder extends Controller
{
    public function __construct(
        private readonly GetCancelledOrdersContract $getCancelledOrdersAction,
    ) {
    }

    /**
     * Get cancelled orders - Return a List of Orders have been cancelled
     */
    public function __invoke(GetOrderRequest $request): mixed
    {
        $orders = $this->getCancelledOrdersAction->handle($request->getPagingData());

        return OrderResource::collection($orders);
    }
}
