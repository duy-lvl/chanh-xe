<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Account;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Account\CreateStaffAccountRequest;
use App\Http\Api\Responses\Internal\Account\CreateStaffAccountResponse;
use Domain\Internal\Actions\Account\Write\CreateStaffAccountContract;
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
final class CreateStaffAccount extends Controller
{
    public function __construct(
        private readonly CreateStaffAccountContract $createStaffAccountAction,
    ) {
    }

    /**
     * Create Staff Account - Return with a randomly generated password
     */
    public function __invoke(CreateStaffAccountRequest $request): JsonResource
    {
        $payload = $request->getNewStaffAccountData();

        $result = $this->createStaffAccountAction->handle(
            data: $payload,
        );

        return new CreateStaffAccountResponse($result);
    }
}
