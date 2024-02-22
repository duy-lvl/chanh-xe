<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Order\GetEndingOrdersRequest;
use App\Http\Api\Responses\Partner\Order\CancelledOrderResource;
use Domain\Partner\Actions\Order\Read\GetCancelledOrdersContract as GetPartnerCancelledOrdersActionContract;
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
final class GetCancelledOrders extends Controller
{
    public function __construct(
        private readonly GetPartnerCancelledOrdersActionContract $getPartnerCancelledOrdersAction,
    ) {
    }

    /**
     * Get cancelled orders - Return a List of Orders cancelled
     */
    public function __invoke(GetEndingOrdersRequest $request): mixed
    {
        $orders = $this->getPartnerCancelledOrdersAction->handle(Auth::id(), $request->getPagingData());

        return CancelledOrderResource::collection($orders);
    }
}
