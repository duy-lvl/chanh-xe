<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Order\GetEndingOrdersRequest;
use App\Http\Api\Responses\Partner\Order\OrdersResource;
use Domain\Partner\Actions\Order\Read\GetPartnerEndingOrdersContract as GetPartnerEndingOrdersActionContract;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Order
 *
 * @subgroupDescription Order interactions
 */
final class GetEndingOrders extends Controller
{
    public function __construct(
        private readonly GetPartnerEndingOrdersActionContract $getPartnerEndingOrdersAction,
    ) {
    }

    /**
     * Get ending orders - Return a List of Orders to be picked up from hubs and waiting for customers to receive
     */
    public function __invoke(GetEndingOrdersRequest $request): mixed
    {
        $orders = $this->getPartnerEndingOrdersAction->handle(Auth::id(), $request->getPagingData());

        return OrdersResource::collection($orders);
    }
}
