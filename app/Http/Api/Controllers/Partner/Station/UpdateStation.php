<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Station;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Station\UpdateStationRequest;
use Domain\Partner\Actions\Station\Write\UpdateStationContract;

/**
 * @group Partner
 *
 * APIs for partner app
 *
 * @subgroup Station
 *
 * @subgroupDescription Station Management
 */
final class UpdateStation extends Controller
{
    public function __construct(
        private readonly UpdateStationContract $updateStationAction
    ) {
    }

    /**
     * Create Station - Handle an incoming create station request from partner.
     */
    public function __invoke(UpdateStationRequest $request): mixed
    {
        $data = $request->getUpdatableStationData();

        $this->updateStationAction->handle($data);

        return response()->make(
            status: 201
        );
    }
}
