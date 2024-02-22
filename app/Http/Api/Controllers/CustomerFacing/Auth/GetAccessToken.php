<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Auth;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Auth\GetCustomerAccessTokenRequest;
use App\Http\Api\Responses\CustomerFacing\Auth\AuthenticateResponseResource;
use Domain\CustomerFacing\Actions\Auth\Read\GetCustomerAccountForLoginContract;
use Domain\CustomerFacing\DataTransferObjects\Auth\AuthenticateResponseData;
use Domain\Shared\Actions\Auth\Write\CreateAccessTokenContract;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Auth
 *
 * @subgroupDescription Auth for customer
 */
final class GetAccessToken extends Controller
{
    public function __construct(
        private readonly GetCustomerAccountForLoginContract $getAccountAction,
        private readonly CreateAccessTokenContract $createAccessTokenAction,
    ) {
    }

    /**
     * Login Customer - Return a personal access token.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(GetCustomerAccessTokenRequest $request): JsonResource
    {
        $data = $request->toDto();

        $account = $this->getAccountAction->handle(data: $data);

        $token = $this->createAccessTokenAction->handle($account, $data->deviceName);

        return new AuthenticateResponseResource(
            AuthenticateResponseData::fromModel($account, $token)
        );
    }
}
