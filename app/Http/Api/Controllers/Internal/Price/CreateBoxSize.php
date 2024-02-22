<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Price;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Price\CreateBoxSizeRequest;
use App\Http\Api\Responses\Internal\Price\BoxSizeResource;
use Domain\Internal\Actions\Price\Write\CreateBoxSizeContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Price
 *
 * @subgroupDescription Price management
 */
final class CreateBoxSize extends Controller
{
    public function __construct(
        private readonly CreateBoxSizeContract $createBoxSizeAction,
    ) {
    }

    /**
     * Create box size
     */
    public function __invoke(CreateBoxSizeRequest $request): mixed
    {
        $payload = $request->getNewBoxSizeData();
        $boxSize = $this->createBoxSizeAction->handle($payload);

        if (null === $boxSize) {
            return abort(code: 400, message: 'Create failed');
        }

        return new BoxSizeResource($boxSize);
    }
}
