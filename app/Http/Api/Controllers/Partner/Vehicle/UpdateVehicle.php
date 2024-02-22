<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Vehicle;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Vehicle\UpdateVehicleRequest;
use Domain\Partner\Actions\Vehicle\Write\UpdateVehicleContract;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for partner app
 *
 * @subgroup Vehicle
 *
 * @subgroupDescription Vehicle management
 */
final class UpdateVehicle extends Controller
{
    public function __construct(
        private readonly UpdateVehicleContract $updateVehicleAction
    ) {}

    /**
     * Update Vehicle - Handle an incoming Update Vehicle request from partner.
     */
    public function __invoke(UpdateVehicleRequest $request): mixed
    {
        $data = $request->getVehicleData();

        $this->updateVehicleAction->handle(Auth::id(), $data);

        return response()->make(content: __('message.partner_vehicle.updated'), status: 200);
    }
}
