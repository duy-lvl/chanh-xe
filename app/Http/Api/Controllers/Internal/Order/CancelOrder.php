<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Order\CancelOrderRequest;
use Domain\Internal\Actions\Order\Write\CancelOrderContract;
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
final class CancelOrder extends Controller
{
    public function __construct(
        private readonly CancelOrderContract $cancelOrderAction,
    ) {
    }

    /**
     * Confirm order - Update an order's status to Confirmed
     */
    public function __invoke(CancelOrderRequest $request, string $code): mixed
    {
        $reason = $request->getCancelledReason();

        $this->cancelOrderAction->handle(Auth::id(), $code, $reason);

        return response()->make(content: "Cancelled successfully", status: 200);
    }
}
