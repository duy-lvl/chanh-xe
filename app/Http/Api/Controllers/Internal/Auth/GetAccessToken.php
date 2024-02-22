<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Auth;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Auth\GetStaffAccessTokenRequest;
use App\Http\Api\Responses\Internal\Auth\LoginTokenResponse;
use Domain\Internal\Actions\Auth\Read\GetStaffAccountForLoginContract;
use Domain\Internal\DataTransferObjects\Auth\LoginResponseData;
use Domain\Shared\Actions\Auth\Write\CreateAccessTokenContract;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Auth
 *
 * @subgroupDescription Auth for Staffs
 */
final class GetAccessToken extends Controller
{
    public function __construct(
        private readonly GetStaffAccountForLoginContract $getAccountAction,
        private readonly CreateAccessTokenContract $createAccessTokenAction,
    ) {
    }

    /**
     * Login Staff - Return a personal access token.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(GetStaffAccessTokenRequest $request): JsonResource
    {
        $data = $request->toDto();

        $account = $this->getAccountAction->handle(data: $data);

        $token = $this->createAccessTokenAction->handle(
            account: $account,
            deviceName: $data->deviceName,
        );

        return new LoginTokenResponse(
            LoginResponseData::fromModel($account, $token)
        );
    }
}
