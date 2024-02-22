<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Order\UpdateOrderRequest;
use Domain\CustomerFacing\Actions\Order\Write\UpdateOrderContract as UpdateOrderActionContract;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Order
 *
 * @subgroupDescription customer create order
 */
final class UpdateOrder extends Controller
{
    public function __construct(
        private readonly UpdateOrderActionContract $updateOrderAction
    ) {
    }

    /**
     * Customer update order - Handle an incoming update order request from customer.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(UpdateOrderRequest $request, string $code): mixed
    {
        $data = $request->getUpdateOrderData();

        $this->updateOrderAction->handle($code, $data);

        return response()->make(content: "Updated successfully", status:200);
    }
}
