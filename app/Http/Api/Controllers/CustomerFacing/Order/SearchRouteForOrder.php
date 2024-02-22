<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Order;

use App\Exceptions\SearchOrderRouteException;
use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Order\RouteSearchRequest;
use App\Http\Api\Responses\CustomerFacing\Order\RouteSearchResponse;
use Carbon\CarbonImmutable;
use DateTimeImmutable;
use Domain\CustomerFacing\Actions\Order\Read\SearchRouteContract;
use Domain\Shared\DataTransferObjects\PositionCodeData;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Order
 *
 * @subgroupDescription Order for customer
 */
final class SearchRouteForOrder extends Controller
{
    public function __construct(
        private readonly SearchRouteContract $searchRouteAction,
    ) {
    }

    /**
     * Search Route - Search available routes for an order
     */
    public function __invoke(RouteSearchRequest $request): JsonResource
    {
        $startPosition = $request->getStartPosition();
        $startPositionCode = $request->getStartPositionCodeData();
        $startMaxDistance = $request->getStartMaxDistance();

        $endPosition = $request->getEndPosition();
        $endPositionCode = $request->getEndPositionCodeData();
        $endMaxDistance = $request->getEndMaxDistance();

        $packageTypes = $request->getPackageTypes();
        $numberOfResults = $request->getNumberOfResults();

        $result = $this->isCachable($startPositionCode, $endPositionCode)
            ? Cache::remember(
                key: $this->getCacheKey($startPositionCode, $endPositionCode),
                ttl: now()->addHours(5),
                callback: fn () => $this->callService($startPosition, $startPositionCode, $startMaxDistance, $endPosition, $endPositionCode, $endMaxDistance, $packageTypes, $numberOfResults)
            )
            : $result = $this->callService($startPosition, $startPositionCode, $startMaxDistance, $endPosition, $endPositionCode, $endMaxDistance, $packageTypes, $numberOfResults);


        return RouteSearchResponse::collection($result);
    }

    private function callService($startPosition, $startPositionCode, $startMaxDistance, $endPosition, $endPositionCode, $endMaxDistance, $packageTypes, $numberOfResults): Collection
    {
        try {
            return $this->searchRouteAction->handle(
                $startPosition,
                $startPositionCode,
                $startMaxDistance,
                $endPosition,
                $endPositionCode,
                $endMaxDistance,
                $packageTypes,
                $numberOfResults,
            );
        } catch (SearchOrderRouteException) {
            return new Collection;
        }
    }

    private function isCachable($startPositionCode, $endPositionCode): bool
    {
        return ($startPositionCode !== null) && ($endPositionCode !== null);
    }

    private function getCacheKey(PositionCodeData $start, PositionCodeData $end): string
    {
        return $start->cityCode . '|' . $start->districtCode . '|' . $end->cityCode . '|' . $end->districtCode;
    }
}
