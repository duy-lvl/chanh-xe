<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Order;

use Illuminate\Support\Facades\Auth;
use App\Http\Api\Controllers\Controller;
use Domain\Partner\Actions\Order\Read\GetPartnerStartingOrdersContract as GetPartnerStartingOrdersActionContract;
use App\Http\Api\Responses\Partner\Order\OrdersResource;
use App\Http\Api\Requests\Partner\Order\GetStartingOrdersRequest;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Order
 *
 * @subgroupDescription Order interactions
 */
final class GetStartingOrders extends Controller
{
    public function __construct(
        private readonly GetPartnerStartingOrdersActionContract $getPartnerStartingOrdersAction,
    ) {
    }

    /**
     * Get starting orders - Return a List of Orders that are about to be brought in by customers
     */
    public function __invoke(GetStartingOrdersRequest $request): mixed
    {
        $orders = $this->getPartnerStartingOrdersAction->handle(Auth::id(), $request->getPagingData());

        return OrdersResource::collection($orders);
    }
}
