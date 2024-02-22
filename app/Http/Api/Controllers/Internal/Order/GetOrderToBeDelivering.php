<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Order\GetToBeDeliveringRequest;
use App\Http\Api\Responses\Internal\Order\OrderListResource;
use Domain\Internal\Actions\Order\Read\GetOrderToBeDeliveringContract;
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
final class GetOrderToBeDelivering extends Controller
{
    public function __construct(
        private readonly GetOrderToBeDeliveringContract $getOrderToBeDeliveringAction,
    ) {
    }

    /**
     * Get delivered orders - Return a List of Orders at hub that will be sent to partner
     */
    public function __invoke(GetToBeDeliveringRequest $request): mixed
    {
        $orders = $this->getOrderToBeDeliveringAction->handle(Auth::id(), $request->getPagingData());

        return OrderListResource::collection($orders);
    }
}
