<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Order\UpdateOrderStatusRequest;
use Domain\Partner\Actions\Order\Write\UpdateDeliveredStatusContract;
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
final class UpdateDeliveredStatus extends Controller
{
    public function __construct(
        private readonly UpdateDeliveredStatusContract $updateDeliveredStatusAction,
    ) {
    }

    /**
     * Delivered - Update an order's status to Delivered
     */
    public function __invoke(UpdateOrderStatusRequest $request, string $code): mixed
    {
        $this->updateDeliveredStatusAction->handle(Auth::id(), $code);

        return response()->make(status: 200, content: 'Update successfully');
    }
}
