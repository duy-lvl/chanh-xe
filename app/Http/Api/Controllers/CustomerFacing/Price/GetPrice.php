<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Price;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\CustomerFacing\Price\GetPriceResponse;
use Domain\CustomerFacing\Actions\Price\Read\GetPriceContract;
use Illuminate\Http\Request;

/**
 * @group Customer Facing
 *
 * APIs for Customer app
 *
 * @subgroup Price
 *
 * @subgroupDescription customer get price 
 */
final class GetPrice extends Controller
{
    public function __construct(
        private readonly GetPriceContract $getPriceAction,
    ) {
    }

    /**
     * Get price - Handle an incoming get price request from customer.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request): mixed
    {
        $length = $request->float('length');
        $width = $request->float('width');
        $height = $request->float('height');
        $weight = $request->float('weight');
        $distance = $request->float('distance');
        $price = $this->getPriceAction->handle($length, $width, $height, $weight, $distance);
        return new GetPriceResponse($price);
    }
}
