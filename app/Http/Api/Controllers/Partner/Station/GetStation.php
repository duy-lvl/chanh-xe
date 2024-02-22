<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Station;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Station\GetStationsRequest;
use App\Http\Api\Responses\Partner\Station\StationResource;
use Domain\Partner\Actions\Station\Read\GetStationContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Station
 *
 * @subgroupDescription Partner get stations
 */
final class GetStation extends Controller
{
    public function __construct(
        private readonly GetStationContract $getStationAction,
    ) {
    }

    /**
     * Get Station - Handle an incoming get station request from partner.
     */
    public function __invoke(GetStationsRequest $request): mixed
    {
        $stations = $this->getStationAction->handle(Auth::id(), $request->getPagingData());

        return StationResource::collection($stations);
    }
}
