<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Order\CancelOrderRequest;
use Auth;
use Domain\CustomerFacing\Actions\Order\Write\CancelOrderContract;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Order
 *
 * @subgroupDescription customer create order
 */
final class CancelOrder extends Controller
{
    public function __construct(
        private readonly CancelOrderContract $cancelOrderAction
    ) {
    }

    /**
     * Customer cancel order - Handle an incoming cancel order request from customer.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(CancelOrderRequest $request, string $code): mixed
    {
        $identifier = $request->getIdentifier();
        $customerId = Auth::guard('api_customer')->id() ?? null;

        $this->cancelOrderAction->handle($customerId, $identifier, $code);

        return response()->make(content: "Cancelled successfully", status: 200);
    }
}
