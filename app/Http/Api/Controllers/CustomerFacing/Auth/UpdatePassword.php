<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Auth;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Auth\UpdatePasswordRequest;
use Domain\Shared\Actions\Auth\Write\UpdatePasswordContract;
use Illuminate\Http\Response;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Auth
 *
 * @subgroupDescription Auth for customer
 */
final class UpdatePassword extends Controller
{
    public function __construct(
        private readonly UpdatePasswordContract $updatePasswordAction,
    ) {
    }

    /**
     * Customer update password 
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(UpdatePasswordRequest $request): Response
    {
        $account = $this->updatePasswordAction->handle(
            account: $request->user(),
            password: $request->validated()['new_password']
        );

        return response(status: 200);
    }
}
