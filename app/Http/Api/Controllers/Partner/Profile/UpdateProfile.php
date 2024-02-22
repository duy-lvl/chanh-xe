<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Profile;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Profile\UpdateProfileRequest;
use Domain\Partner\Actions\Profile\Write\UpdateProfileContract;
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
final class UpdateProfile extends Controller
{
    public function __construct(
        private readonly UpdateProfileContract $updateProfileAction
    ) {}

    /**
     * Update Self Profile
     */
    public function __invoke(UpdateProfileRequest $request): mixed
    {
        $data = $request->getProfileData();

        $this->updateProfileAction->handle(Auth::id(), $data);

        return response()->make(content: "Profile has been updated", status: 200);
    }
}
