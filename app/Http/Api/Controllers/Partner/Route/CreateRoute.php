<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Route;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Route\CreateRouteRequest;
use Domain\Partner\Actions\Route\Write\CreateRouteContract;
use Illuminate\Http\Response;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Route
 *
 * @subgroupDescription Partner create routes
 */
final class CreateRoute extends Controller
{
    public function __construct(
        private readonly CreateRouteContract $createRouteAction,
    ) {
    }

    /**
     * Create Route - Handle an incoming create route request from partner.
     */
    public function __invoke(CreateRouteRequest $request): Response
    {
        $data = $request->toDto();

        $route = $this->createRouteAction->handle(data: $data);

        return response()->make(status: 201);
    }
}
