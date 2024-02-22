<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Auth;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Auth\UpdatePasswordRequest;
use Domain\Shared\Actions\Auth\Write\UpdatePasswordContract;
use Illuminate\Http\Response;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Auth
 *
 * @subgroupDescription Auth for Partner
 */
final class UpdatePassword extends Controller
{
    public function __construct(
        private readonly UpdatePasswordContract $updatePasswordAction,
    ) {
    }

    /**
     * Partner update password
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
