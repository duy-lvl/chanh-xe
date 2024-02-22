<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Order\ConfirmOrderRequest;
use Domain\Partner\Actions\Order\Write\ConfirmOrderContract;
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
final class ConfirmOrder extends Controller
{
    public function __construct(
        private readonly ConfirmOrderContract $confirmOrderAction,
    ) {
    }

    /**
     * Confirm order - Update an order's status to Confirmed
     */
    public function __invoke(ConfirmOrderRequest $request): mixed
    {
        $confirmData = $request->getConfirmationData();

        $this->confirmOrderAction->handle(Auth::id(), $confirmData);

        return response()->make(content: "Confirmed successfully", status: 200);
    }
}
