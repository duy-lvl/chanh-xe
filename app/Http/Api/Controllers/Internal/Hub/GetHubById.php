<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Hub;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Internal\Hub\GetHubByIdResponse;
use Domain\Internal\Actions\Hub\Read\GetHubByIdContract;
use Domain\Internal\DataTransferObjects\Hub\HubData;
use Illuminate\Http\Request;

/**
 * @group Internal
 *
 * APIs for internal app
 *
 * @subgroup Hub
 *
 * @subgroupDescription admin get hub by id
 */
final class GetHubById extends Controller
{
    public function __construct(
        private readonly GetHubByIdContract $getHubByIdAction
    ) {
    }

    /**
     * Get Hub by id - Handle an incoming get hub by id request from admin.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request, int $id): mixed
    {
        $hubData = $this->getHubByIdAction->handle($id);
        if ($hubData === null) {
            // return response(content: 'Hub id not found', status: 404);
            return abort(code: 404, message: 'Hub id not found');
        }
        
        return new GetHubByIdResponse($hubData);
    }
}
