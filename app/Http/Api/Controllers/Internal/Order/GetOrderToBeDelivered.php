<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Order\GetToBeDeliveredRequest;
use App\Http\Api\Responses\Internal\Order\OrderListResource;
use Domain\Internal\Actions\Order\Read\GetOrderToBeDeliveredContract;
use Illuminate\Support\Facades\Auth;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Order
 *
 * @subgroupDescription Order interactions
 */
final class GetOrderToBeDelivered extends Controller
{
    public function __construct(
        private readonly GetOrderToBeDeliveredContract $getOrderToBeDeliveredAction,
    ) {
    }

    /**
     * Get delivering orders - Return a List of Orders delivering to hub
     */
    public function __invoke(GetToBeDeliveredRequest $request): mixed
    {
        $orders = $this->getOrderToBeDeliveredAction->handle(Auth::id(), $request->getPagingData());

        return OrderListResource::collection($orders);
    }
}
