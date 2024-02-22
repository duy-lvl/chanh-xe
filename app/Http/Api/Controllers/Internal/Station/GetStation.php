<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Station;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Station\GetStationsRequest;
use App\Http\Api\Responses\Partner\Station\StationResource;
use Domain\Partner\Actions\Station\Read\GetStationContract;
use Illuminate\Http\Request;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Station
 *
 * @subgroupDescription Station management
 */
final class GetStation extends Controller
{
    public function __construct(
        //TODO: New contract for admin???
        private readonly GetStationContract $getStationAction,
    ) {
    }

    /**
     * Get Station - Handle an incoming get station request from admin.
     */
    public function __invoke(GetStationsRequest $request): mixed
    {
        $stations = $this->getStationAction->handle(partnerId: null, pagingData: $request->getPagingData());

        return StationResource::collection($stations);
    }
}
