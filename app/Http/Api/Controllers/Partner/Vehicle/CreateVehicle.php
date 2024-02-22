<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Vehicle;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Vehicle\CreateVehicleRequest;
use Domain\Partner\Actions\Vehicle\Write\CreateVehicleContract;

/**
 * @group Partner
 *
 * APIs for partner app
 *
 * @subgroup Vehicle
 *
 * @subgroupDescription Vehicle management
 */
final class CreateVehicle extends Controller
{
    public function __construct(
        private readonly CreateVehicleContract $createVehicleAction
    ) {}

    /**
     * Create Vehicle - Handle an incoming Create Vehicle request from partner.
     */
    public function __invoke(CreateVehicleRequest $request): mixed
    {
        $data = $request->getVehicleData();

        $this->createVehicleAction->handle($data);

        return response()->make(content: __('messages.partner_vehicle.created') , status: 201);
    }
}
