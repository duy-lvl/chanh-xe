<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\CustomerFacing\Order\CompactOrderResource;
use Domain\CustomerFacing\Actions\Order\Read\GetOrderListContract as GetOrderListActionContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Order
 *
 * @subgroupDescription view order list
 */
final class GetCustomerOrderHistory extends Controller
{
    public function __construct(
        private readonly GetOrderListActionContract $getOrderListAction
    ) {
    }

    /**
     * View orders - Return list of orders belong to current user
     */
    public function __invoke(Request $request): mixed
    {
        $page = null !== $request->input('page') ? (int) $request->input('page') : null;
        $perPage = null !== $request->input('per_page') ? (int) $request->input('per_page') : null;

        $orders = $this->getOrderListAction->handle(Auth::id(), $page, $perPage);

        return CompactOrderResource::collection($orders);
    }
}
