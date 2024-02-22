<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Account;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Account\GetCustomerAccountRequest;
use App\Http\Api\Responses\Internal\Account\GetCustomerAccountResponse;
use Domain\Internal\Actions\Account\Read\GetCustomerAccountContract;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Account
 *
 * @subgroupDescription Account management
 */
final class GetCustomerAccount extends Controller
{
    public function __construct(
        private readonly GetCustomerAccountContract $getCustomerAccountAction,
    ) {
    }

    /**
     * Get Customer Account - Return list of customer accounts
     */
    public function __invoke(GetCustomerAccountRequest $request): JsonResource
    {
        $pagingData = $request->getPagingData();

        $staffs = $this->getCustomerAccountAction->handle(
            pagingData: $pagingData
        );

        return GetCustomerAccountResponse::collection($staffs);
    }
}
