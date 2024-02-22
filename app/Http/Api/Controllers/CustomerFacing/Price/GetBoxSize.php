<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Price;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\CustomerFacing\Price\BoxSizeResponse;
use Domain\CustomerFacing\Actions\Price\Read\GetBoxSizeContract;
use Illuminate\Http\Request;

/**
 * @group Customer Facing
 *
 * APIs for Customer app
 *
 * @subgroup Price
 *
 * @subgroupDescription customer get box size
 */
final class GetBoxSize extends Controller
{
    public function __construct(
        private readonly GetBoxSizeContract $getBoxSizeAction,
    ) {
    }

    /**
     * Get box sizes and corresponding prices - Handle an incoming get price request from customer.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request): mixed
    {
        $boxSizes = $this->getBoxSizeAction->handle();

        return new BoxSizeResponse($boxSizes);
    }
}
