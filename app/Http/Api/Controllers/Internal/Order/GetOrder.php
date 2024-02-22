<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Order\GetOrderRequest;
use App\Http\Api\Responses\Internal\Order\OrderResource;
use Domain\Internal\Actions\Order\Read\GetOrderContract;
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
final class GetOrder extends Controller
{
    public function __construct(
        private readonly GetOrderContract $getOrderAction,
    ) {
    }

    /**
     * Get delivering orders - Return a List of Orders delivering to hub
     */
    public function __invoke(GetOrderRequest $request): mixed
    {
        $orders = $this->getOrderAction->handle(Auth::id(), $request->getPagingData());

        return OrderResource::collection($orders);
    }
}
