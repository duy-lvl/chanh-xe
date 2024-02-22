<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Auth;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Auth\GetPartnerAccessTokenRequest;
use App\Http\Api\Responses\Partner\Auth\LoginTokenResponse;
use Domain\Partner\Actions\Auth\Read\GetPartnerAccountForLoginContract;
use Domain\Partner\DataTransferObjects\Auth\LoginResponseData;
use Domain\Shared\Actions\Auth\Write\CreateAccessTokenContract;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Auth
 *
 * @subgroupDescription Auth for Partner
 */
final class GetAccessToken extends Controller
{
    public function __construct(
        private readonly GetPartnerAccountForLoginContract $getAccountAction,
        private readonly CreateAccessTokenContract $createAccessTokenAction,
    ) {
    }

    /**
     * Login Partner - Return a personal access token.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(GetPartnerAccessTokenRequest $request): JsonResource
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
