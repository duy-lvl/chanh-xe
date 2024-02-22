<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Hub;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Hub\CreateHubRequest;
use Domain\Internal\Actions\Hub\Write\CreateHubContract;

/**
 * @group Internal
 *
 * APIs for internal app
 *
 * @subgroup Hub
 *
 * @subgroupDescription admin manage hub
 */
final class CreateHub extends Controller
{
    public function __construct(
        private readonly CreateHubContract $createHubAction
    ) {
    }

    /**
     * Create Hub - Handle an incoming create hub request from admin.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(CreateHubRequest $request): mixed
    {
        $data = $request->toDto();

        $hub = $this->createHubAction->handle($data);

        return response()->make(status: 201);
    }
}
