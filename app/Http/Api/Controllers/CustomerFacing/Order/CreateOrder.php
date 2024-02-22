<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Order\CreateOrderRequest;
use App\Http\Api\Responses\CustomerFacing\Order\CreateOrderResource;
use Domain\CustomerFacing\Actions\Order\Write\CreateOrderContract as CreateOrderActionContract;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Order
 *
 * @subgroupDescription customer create order
 */
final class CreateOrder extends Controller
{
    public function __construct(
        private readonly CreateOrderActionContract $createOrderAction
    ) {
    }

    /**
     * Customer create order - Handle an incoming create order request from customer.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(CreateOrderRequest $request): mixed
    {
        $data = $request->getNewOrderData();

        $orderDetailData = $this->createOrderAction->handle($data);

        return new CreateOrderResource($orderDetailData);
    }
}
