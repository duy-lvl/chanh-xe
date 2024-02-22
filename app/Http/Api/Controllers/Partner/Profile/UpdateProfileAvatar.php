<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Profile;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Profile\UpdateProfileAvatarRequest;
use Domain\Partner\Actions\Profile\Write\UpdateProfileAvatarContract;
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
final class UpdateProfileAvatar extends Controller
{
    public function __construct(
        private readonly UpdateProfileAvatarContract $updateProfileAvatarAction
    ) {}

    /**
     * Update Self Avatar
     */
    public function __invoke(UpdateProfileAvatarRequest $request): mixed
    {
        $avatar = $request->getProfileImage();

        $this->updateProfileAvatarAction->handle(Auth::id(), $avatar);

        return response()->make(content: "Avatar has been updated", status: 200);
    }
}
