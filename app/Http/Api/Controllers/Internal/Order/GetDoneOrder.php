<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Order\GetOrderRequest;
use App\Http\Api\Responses\Internal\Order\OrderResource;
use Domain\Internal\Actions\Order\Read\GetDoneOrdersContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Order
 *
 * @subgroupDescription Order interactions
 */
final class GetDoneOrder extends Controller
{
    public function __construct(
        private readonly GetDoneOrdersContract $getDoneOrdersAction,
    ) {
    }

    /**
     * Get done orders - Return a List of Orders have been done
     */
    public function __invoke(GetOrderRequest $request): mixed
    {
        $orders = $this->getDoneOrdersAction->handle($request->getPagingData());

        return OrderResource::collection($orders);
    }
}
