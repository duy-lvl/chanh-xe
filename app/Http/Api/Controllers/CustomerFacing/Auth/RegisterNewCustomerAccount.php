<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Auth;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Auth\RegisterRequest;
use App\Http\Api\Responses\CustomerFacing\Auth\AuthenticateResponseResource;
use Domain\CustomerFacing\Actions\Auth\Write\RegisterNewCustomerAccountContract;
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
final class RegisterNewCustomerAccount extends Controller
{
    public function __construct(
        private readonly RegisterNewCustomerAccountContract $registerNewCustomerAccountAction,
        private readonly CreateAccessTokenContract $createAccessTokenAction,
    ) {
    }

    /**
     * Register Customer - Handle an incoming registration request from customer.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(RegisterRequest $request): JsonResource
    {
        $data = $request->toDto();

        $account = $this->registerNewCustomerAccountAction->handle($data);

        $token = $token = $this->createAccessTokenAction->handle($account, $request->safe()['device_name']);

        return new AuthenticateResponseResource(
            AuthenticateResponseData::fromModel($account, $token)
        );
    }
}
