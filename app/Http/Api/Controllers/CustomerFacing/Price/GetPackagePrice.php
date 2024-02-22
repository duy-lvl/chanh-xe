<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Price;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Price\GetPackagePriceRequest;
use App\Http\Api\Responses\CustomerFacing\Price\GetPriceResponse;
use Domain\CustomerFacing\Actions\Price\Read\GetPackagePriceContract as GetPackagePriceActionContract;
use Illuminate\Http\Request;

/**
 * @group Customer Facing
 *
 * APIs for Customer app
 *
 * @subgroup Price
 *
 * @subgroupDescription Price calculation
 */
final class GetPackagePrice extends Controller
{
    public function __construct(
        private readonly GetPackagePriceActionContract $getPackagePriceAction,
    ) {
    }

    /**
     * Get price - Handle an incoming get price request from customer.
     */
    public function __invoke(GetPackagePriceRequest $request): mixed
    {
        return new GetPriceResponse(
            $this->getPackagePriceAction->handle(
                weight: $request->getPackageWeight(),
                dimensions: $request->getPackageDimension(),
                distance: $request->getDistance(),
            )
        );
    }
}
