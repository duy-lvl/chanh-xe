<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Account;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Account\GetStaffAccountRequest;
use App\Http\Api\Responses\Internal\Account\GetStaffAccountResponse;
use Auth;
use Domain\Internal\Actions\Account\Read\GetStaffAccountContract;
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
final class GetStaffAccount extends Controller
{
    public function __construct(
        private readonly GetStaffAccountContract $getStaffAccountAction,
    ) {
    }

    /**
     * Get Staff Account - Return list of staff accounts
     */
    public function __invoke(GetStaffAccountRequest $request): JsonResource
    {
        $pagingData = $request->getPagingData();

        $staffs = $this->getStaffAccountAction->handle(
            adminId: Auth::id(),
            pagingData: $pagingData
        );

        return GetStaffAccountResponse::collection($staffs);
    }
}
