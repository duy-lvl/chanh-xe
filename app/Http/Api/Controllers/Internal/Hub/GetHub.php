<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Hub;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Partner\Hub\GetHubResource;
use Domain\Partner\Actions\Hub\Read\GetHubContract;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Internal
 *
 * APIs for internal app
 *
 * @subgroup Hub
 *
 * @subgroupDescription admin manage hubs
 */
final class GetHub extends Controller
{
    public function __construct(
        private readonly GetHubContract $getHubAction,
    ) {
    }

    /**
     * Get Hub - Handle an incoming get hubs request from admin.
     */
    public function __invoke(Request $request): JsonResource
    {
        $hubs = $this->getHubAction->handle();
        return GetHubResource::collection($hubs);
    }
}
