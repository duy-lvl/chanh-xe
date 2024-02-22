<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Price;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Price\CreatePriceRequest;
use Domain\Internal\Actions\Price\Write\CreatePriceContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Price
 *
 * @subgroupDescription Price management
 */
final class CreatePrice extends Controller
{
    public function __construct(
        private readonly CreatePriceContract $createPriceAction,
    ) {
    }

    /**
     * Create Price table
     */
    public function __invoke(CreatePriceRequest $request, int $boxSizeId): mixed
    {
        $payload = $request->getNewPriceData();
        $result = $this->createPriceAction->handle(
            boxSizeId: $boxSizeId,
            data: $payload,
        );
        if ( ! $result) {
            return abort(code: 400, message: 'Bad request');
        }

        return response()->make(status: 200);
    }
}
