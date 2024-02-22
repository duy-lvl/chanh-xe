<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Vehicle;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Vehicle\UpdateVehicleImageRequest;
use Domain\Partner\Actions\Vehicle\Write\UpdateVehicleImageContract;
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
final class UpdateVehicleImage extends Controller
{
    public function __construct(
        private readonly UpdateVehicleImageContract $updateVehicleImageAction
    ) {}

    /**
     * Update Self Image
     */
    public function __invoke(UpdateVehicleImageRequest $request): mixed
    {
        $image = $request->getVehicleImage();
        $vehicleId = $request->getVehicleId();

        $this->updateVehicleImageAction->handle(Auth::id(), $vehicleId, $image);

        return response()->make(content: "Image has been updated", status: 200);
    }
}
