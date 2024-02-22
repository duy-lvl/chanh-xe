<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Order;

use App\Http\Api\Controllers\Controller;
use Domain\Internal\Actions\Order\Write\StaffUpdateDeliveredStatusContract as UpdateDeliveredStatusActionContract;
use Illuminate\Support\Facades\Auth;
use Request;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Order
 *
 * @subgroupDescription Staff update order status to delivered
 */
final class StaffUpdateDeliveredStatus extends Controller
{
    public function __construct(
        private readonly UpdateDeliveredStatusActionContract $updateDeliveredStatusAction,
    ) {
    }

    /**
     * Update order status to delivered
     */
    public function __invoke(Request $request, string $code): mixed
    {
        $this->updateDeliveredStatusAction->handle(Auth::id(), $code);

        return response()->make(status: 200, content: 'Update successfully');
    }
}
