<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Order\UpdateDeliveringStatusRequest;
use Domain\Partner\Actions\Order\Write\UpdateDeliveringStatusContract;
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
final class UpdateDeliveringStatus extends Controller
{
    public function __construct(
        private readonly UpdateDeliveringStatusContract $updateDeliveringStatusAction,
    ) {
    }

    /**
     * Delivering - Update an order's status to Delivering
     */
    public function __invoke(UpdateDeliveringStatusRequest $request): mixed
    {
        $driverId = $request->getDriverId();
        $vehicleId = $request->getVehicleId();
        $code = $request->getCode();
        
        $this->updateDeliveringStatusAction->handle(
            Auth::id(), 
            $code,
            $vehicleId,
            $driverId
        );

        return response()->make(status: 200, content: 'Update successfully');
    }
}
