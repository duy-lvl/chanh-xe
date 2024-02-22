<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Route;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Route\GetRouteRequest;
use App\Http\Api\Responses\Partner\Route\RouteResource;
use Auth;
use Domain\Partner\Actions\Route\Read\GetRouteContract;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Route
 *
 * @subgroupDescription Partner create routes
 */
final class GetRoute extends Controller
{
    public function __construct(
        private readonly GetRouteContract $getRouteAction,
    ) {
    }

    /**
     * Get Route - Handle an incoming get route request from partner.
     */
    public function __invoke(GetRouteRequest $request): mixed
    {
        $pagingData = $request->getPagingData();

        $routes = $this->getRouteAction->handle(Auth::id(), $pagingData);

        return RouteResource::collection($routes);
    }
}
