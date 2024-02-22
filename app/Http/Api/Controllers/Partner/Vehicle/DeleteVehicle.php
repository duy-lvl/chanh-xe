<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Vehicle;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Vehicle\DeleteVehicleRequest;
use Domain\Partner\Actions\Vehicle\Write\DeleteVehicleContract;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Vehicle
 *
 * @subgroupDescription Partner Delete Vehicles
 */
final class DeleteVehicle extends Controller
{
    public function __construct(
        private readonly DeleteVehicleContract $deleteVehicleAction,
    ) {
    }

    /**
     * Delete Vehicle - Handle an incoming Delete Vehicle request from partner.
     */
    public function __invoke(DeleteVehicleRequest $request): mixed
    {
        $vehicleId = $request->getId();
        $this->deleteVehicleAction->handle(partnerId: Auth::id(), vehicleId: $vehicleId);
        return response()->make(__('messages.partner_vehicle.deleted'));
    }
}
