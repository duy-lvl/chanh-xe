<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\CustomerFacing\Order\TrackingOrderResource;
use Domain\CustomerFacing\Actions\Order\Read\TrackingOrderContract as GetOrderTrackingDataActionContract;
use Illuminate\Http\Request;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Order
 *
 * @subgroupDescription tracking order by code
 */
final class TrackingOrder extends Controller
{
    public function __construct(
        private readonly GetOrderTrackingDataActionContract $getOrderTrackingDataAction
    ) {
    }

    /**
     * Tracking order - Return order data by order's code
     */
    public function __invoke(Request $request, string $code): mixed
    {
        $trackingData = $this->getOrderTrackingDataAction->handle($code);

        if (null === $trackingData) {
            // abort(code: 404, message: 'Order not found');
            return TrackingOrderResource::collection([]);
        }

        return new TrackingOrderResource($trackingData);
    }
}
