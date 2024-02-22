<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Vehicle;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Vehicle\GetInComingVehicleRequest;
use App\Http\Api\Responses\Internal\Vehicle\VehicleResource;
use Domain\Internal\Actions\Vehicle\Read\GetInComingVehicleContract;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Vehicle
 *
 * @subgroupDescription Internal get Vehicles
 */
final class GetInComingVehicle extends Controller
{
    public function __construct(
        private readonly GetInComingVehicleContract $getInComingVehicleAction,
    ) {
    }

    /**
     * Get In-Coming Vehicle - Handle an incoming get Vehicle request from staff.
     */
    public function __invoke(GetInComingVehicleRequest $request): JsonResource
    {
        
        $pagingData = $request->getPagingData();
        $vehicles = $this->getInComingVehicleAction->handle(Auth::id(), $pagingData);
        return VehicleResource::collection($vehicles);
    }
}
