<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Hub;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Partner\Hub\GetHubResource;
use Domain\Partner\Actions\Hub\Read\GetHubContract;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Hub
 *
 * @subgroupDescription Partner get hubs
 */
final class GetHub extends Controller
{
    public function __construct(
        private readonly GetHubContract $getHubAction,
    ) {
    }

    /**
     * Get Hub - Handle an incoming get hub request from partner.
     */
    public function __invoke(Request $request): JsonResource
    {
        $hubs = $this->getHubAction->handle();
        return GetHubResource::collection($hubs);
    }
}
