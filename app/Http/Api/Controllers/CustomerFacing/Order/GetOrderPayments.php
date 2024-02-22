<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Order\ViewOrderPaymentRequest;
use App\Http\Api\Responses\CustomerFacing\Payment\PaymentResource;
use Domain\CustomerFacing\Actions\Order\Read\GetOrderPaymentsContract as GetOrderPaymentsActionContract;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Order
 *
 * @subgroupDescription get payment info of an order by code
 */
final class GetOrderPayments extends Controller
{
    public function __construct(
        private readonly GetOrderPaymentsActionContract $getOrderPaymentsAction
    ) {
    }

    /**
     * View order detail - Return order data of current user by code
     */
    public function __invoke(ViewOrderPaymentRequest $request, string $code): mixed
    {
        $payments = $this->getOrderPaymentsAction->handle($code);

        return PaymentResource::collection($payments);
    }
}
