<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Account;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Account\GetPartnerAccountRequest;
use App\Http\Api\Responses\Internal\Account\GetPartnerAccountResponse;
use Domain\Internal\Actions\Account\Read\GetPartnerAccountContract;
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
final class GetPartnerAccount extends Controller
{
    public function __construct(
        private readonly GetPartnerAccountContract $getPartnerAccountAction,
    ) {
    }

    /**
     * Get Partner Account - Return list of partner accounts
     */
    public function __invoke(GetPartnerAccountRequest $request): JsonResource
    {
        $pagingData = $request->getPagingData();

        $staffs = $this->getPartnerAccountAction->handle(
            pagingData: $pagingData
        );

        return GetPartnerAccountResponse::collection($staffs);
    }
}
