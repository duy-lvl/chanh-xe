<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Order\UpdateDeliveringStatusRequest;
use Domain\Internal\Actions\Order\Write\StaffUpdateDeliveringStatusContract as UpdateDeliveringStatusActionContract;
use Illuminate\Support\Facades\Auth;
use Request;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Order
 *
 * @subgroupDescription Staff update order status to delivering
 */
final class StaffUpdateDeliveringStatus extends Controller
{
    public function __construct(
        private readonly UpdateDeliveringStatusActionContract $updateDeliveringStatusAction,
    ) {
    }

    /**
     * Update order status to delivering
     */
    public function __invoke(UpdateDeliveringStatusRequest $request, string $code): mixed
    {
        $driverId = $request->getDriverId();
        $vehicleId = $request->getVehicleId();
        $this->updateDeliveringStatusAction->handle(Auth::id(), $code, $driverId, $vehicleId);
        return response()->make(status: 200, content: 'Update successfully');
    }
}
