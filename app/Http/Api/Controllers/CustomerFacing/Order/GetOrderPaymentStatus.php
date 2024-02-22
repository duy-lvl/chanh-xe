<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\CustomerFacing\Order\OrderPaymentStatusResource;
use Domain\CustomerFacing\Actions\Order\Read\GetOrderPaymentStatusContract as GetOrderPaymentStatusActionContract;
use Illuminate\Http\Request;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Order
 *
 * @subgroupDescription get payment info of an order by code
 */
final class GetOrderPaymentStatus extends Controller
{
    public function __construct(
        private readonly GetOrderPaymentStatusActionContract $getOrderPaymentStatusAction
    ) {
    }

    /**
     * View order detail - Return order data of current user by code
     */
    public function __invoke(Request $request, string $code): mixed
    {
        $payments = $this->getOrderPaymentStatusAction->handle($code);

        return OrderPaymentStatusResource::make($payments);
    }
}
