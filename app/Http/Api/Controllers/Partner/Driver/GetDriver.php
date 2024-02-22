<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Driver;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Driver\GetDriverRequest;
use App\Http\Api\Responses\Partner\Driver\DriverResource;
use Domain\Partner\Actions\Driver\Read\GetDriverContract;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Driver
 *
 * @subgroupDescription Partner get Drivers
 */
final class GetDriver extends Controller
{
    public function __construct(
        private readonly GetDriverContract $getDriverAction,
    ) {
    }

    /**
     * Get Driver - Handle an incoming get Driver request from partner.
     */
    public function __invoke(GetDriverRequest $request): JsonResource
    {
        $pagingData = $request->getPagingData();
        $drivers = $this->getDriverAction->handle($pagingData, Auth::id());
        return DriverResource::collection($drivers);
    }
}
