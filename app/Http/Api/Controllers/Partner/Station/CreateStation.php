<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Station;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Station\CreateStationRequest;
use Domain\Partner\Actions\Station\Write\CreateStationContract;

/**
 * @group Partner
 *
 * APIs for partner app
 *
 * @subgroup Station
 *
 * @subgroupDescription partner create station
 */
final class CreateStation extends Controller
{
    public function __construct(
        private readonly CreateStationContract $createStationAction
    ) {
    }

    /**
     * Create Station - Handle an incoming create station request from partner.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(CreateStationRequest $request): mixed
    {
        $data = $request->toDto();

        $station = $this->createStationAction->handle($data);

        return response()->make(
            status: 201
        );
    }
}
