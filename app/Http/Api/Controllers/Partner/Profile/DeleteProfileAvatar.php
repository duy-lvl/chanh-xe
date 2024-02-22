<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Profile;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Profile\DeleteProfileAvatarRequest;
use Domain\Partner\Actions\Profile\Write\DeleteProfileAvatarContract;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for partner app
 *
 * @subgroup Profile
 *
 * @subgroupDescription profile management
 */
final class DeleteProfileAvatar extends Controller
{
    public function __construct(
        private readonly DeleteProfileAvatarContract $deleteProfileAvatarAction
    ) {}

    /**
     * Delete Self Avatar
     */
    public function __invoke(DeleteProfileAvatarRequest $request): mixed
    {
        $this->deleteProfileAvatarAction->handle(Auth::id());

        return response()->make(content: "Avatar has been deleted", status: 200);
    }
}
