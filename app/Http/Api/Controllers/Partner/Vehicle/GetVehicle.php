<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Vehicle;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Vehicle\GetVehicleRequest;
use App\Http\Api\Responses\Partner\Vehicle\VehicleResource;
use Domain\Partner\Actions\Vehicle\Read\GetVehicleContract;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Vehicle
 *
 * @subgroupDescription Partner get Vehicles
 */
final class GetVehicle extends Controller
{
    public function __construct(
        private readonly GetVehicleContract $getVehicleAction,
    ) {
    }

    /**
     * Get Vehicle - Handle an incoming get Vehicle request from partner.
     */
    public function __invoke(GetVehicleRequest $request): JsonResource
    {
        $pagingData = $request->getPagingData();
        $vehicles = $this->getVehicleAction->handle($pagingData, Auth::id());
        return VehicleResource::collection($vehicles);
    }
}
