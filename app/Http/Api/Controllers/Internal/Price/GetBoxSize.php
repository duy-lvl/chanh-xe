<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Price;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Price\GetBoxSizeRequest;
use App\Http\Api\Responses\Internal\Price\BoxSizeResource;
use Domain\Internal\Actions\Price\Read\GetBoxSizeContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Price
 *
 * @subgroupDescription Price management
 */
final class GetBoxSize extends Controller
{
    public function __construct(
        private readonly GetBoxSizeContract $getBoxSizeAction,
    ) {
    }

    /**
     * Get box size
     */
    public function __invoke(GetBoxSizeRequest $request): mixed
    {
        $pagingData = $request->getPagingData();
        $boxSizes = $this->getBoxSizeAction->handle($pagingData);
        // if (null === $boxSizes) {
        //     return abort(code: 404, message: 'Not found');
        // }

        return BoxSizeResource::collection($boxSizes);
    }
}
