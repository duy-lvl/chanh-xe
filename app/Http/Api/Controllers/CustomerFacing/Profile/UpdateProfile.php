<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Profile;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Profile\UpdateProfileRequest;
use Domain\CustomerFacing\Actions\Profile\Write\UpdateProfileContract;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Profile
 *
 * @subgroupDescription get self profile
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
        $data = $request->toProfileData();
        $this->updateProfileAction->handle($data);
        return response()->make(content: "Profile has been updated", status: 200);
    }
}
