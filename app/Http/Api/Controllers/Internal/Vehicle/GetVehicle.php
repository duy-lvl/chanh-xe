<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Vehicle;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Vehicle\GetVehicleRequest;
use App\Http\Api\Responses\Internal\Vehicle\VehicleResource;
use Domain\Internal\Actions\Vehicle\Read\GetVehicleContract;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Vehicle
 *
 * @subgroupDescription Internal get Vehicles
 */
final class GetVehicle extends Controller
{
    public function __construct(
        private readonly GetVehicleContract $getVehicleAction,
    ) {
    }

    /**
     * Get Vehicle - Handle an incoming get Vehicle request from staff.
     */
    public function __invoke(GetVehicleRequest $request): JsonResource
    {
        $partnerId = $request->getId();
        $pagingData = $request->getPagingData();
        $vehicles = $this->getVehicleAction->handle($partnerId, $pagingData);
        return VehicleResource::collection($vehicles);
    }
}
