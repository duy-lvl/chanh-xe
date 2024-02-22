<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Order\GetEndingOrdersRequest;
use App\Http\Api\Responses\Partner\Order\DoneOrderResource;
use Domain\Partner\Actions\Order\Read\GetDoneOrdersContract as GetPartnerDoneOrdersActionContract;
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
final class GetDoneOrders extends Controller
{
    public function __construct(
        private readonly GetPartnerDoneOrdersActionContract $getPartnerDoneOrdersAction,
    ) {
    }

    /**
     * Get done orders - Return a List of Orders have been done belong to partner
     */
    public function __invoke(GetEndingOrdersRequest $request): mixed
    {
        $orders = $this->getPartnerDoneOrdersAction->handle(Auth::id(), $request->getPagingData());

        return DoneOrderResource::collection($orders);
    }
}
