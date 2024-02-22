<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\CustomerFacing\Order\OrderDetailResource;
use Domain\CustomerFacing\Actions\Order\Read\GetOrderDetailContract as GetOrderDetailActionContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Order
 *
 * @subgroupDescription tracking order by code
 */
final class ViewOrderDetail extends Controller
{
    public function __construct(
        private readonly GetOrderDetailActionContract $getOrderDetailAction
    ) {
    }

    /**
     * View order detail - Return order data of current user by code
     */
    public function __invoke(Request $request, string $code): mixed
    {
        $orderData = $this->getOrderDetailAction->handle($code);

        if (null === $orderData) {
            abort(code: 404, message: 'Order not found');
        }

        if ($orderData->customerId !== Auth::id()) {
            throw new AuthorizationException();
        }

        return new OrderDetailResource($orderData);
    }
}
