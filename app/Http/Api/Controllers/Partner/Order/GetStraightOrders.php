<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Order;

use Illuminate\Support\Facades\Auth;
use App\Http\Api\Controllers\Controller;
use Domain\Partner\Actions\Order\Read\GetPartnerStraightOrdersContract as GetPartnerStraightOrdersActionContract;
use App\Http\Api\Responses\Partner\Order\OrdersResource;
use App\Http\Api\Requests\Partner\Order\GetStraightOrdersRequest;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Order
 *
 * @subgroupDescription Order interactions
 */
final class GetStraightOrders extends Controller
{
    public function __construct(
        private readonly GetPartnerStraightOrdersActionContract $getPartnerStraightOrdersAction,
    ) {
    }

    /**
     * Get straight orders - Return a List of Orders that are handled by only one partner
     */
    public function __invoke(GetStraightOrdersRequest $request): mixed
    {
        $orders = $this->getPartnerStraightOrdersAction->handle(Auth::id(), $request->getPagingData());

        return OrdersResource::collection($orders);
    }
}
