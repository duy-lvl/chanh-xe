<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Driver;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Driver\GetDriverRequest;
use App\Http\Api\Responses\Internal\Driver\DriverResource;
use Domain\Internal\Actions\Driver\Read\GetDriverContract;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Driver
 *
 * @subgroupDescription Internal get Drivers
 */
final class GetDriver extends Controller
{
    public function __construct(
        private readonly GetDriverContract $getDriverAction,
    ) {
    }

    /**
     * Get Driver - Handle an incoming get Driver request from staff.
     */
    public function __invoke(GetDriverRequest $request): JsonResource
    {
        $partnerId = $request->getId();
        $pagingData = $request->getPagingData();
        $drivers = $this->getDriverAction->handle($partnerId, $pagingData);
        return DriverResource::collection($drivers);
    }
}
