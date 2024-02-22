<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Price;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Price\GetBoxPriceRequest;
use App\Http\Api\Responses\Internal\Price\BoxSizePriceResource;
use Domain\Internal\Actions\Price\Read\GetPriceContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Price
 *
 * @subgroupDescription Price management
 */
final class GetBoxPrice extends Controller
{
    public function __construct(
        private readonly GetPriceContract $getBoxPriceAction,
    ) {
    }

    /**
     * Get box size
     */
    public function __invoke(GetBoxPriceRequest $request, int $boxSizeId): mixed
    {
        $pagingData = $request->getPagingData();
        $prices = $this->getBoxPriceAction->handle($boxSizeId, $pagingData);
        // if (null === $prices) {
        //     return abort(code: 404, message: 'Not found');
        // }

        return BoxSizePriceResource::collection($prices);
    }
}
