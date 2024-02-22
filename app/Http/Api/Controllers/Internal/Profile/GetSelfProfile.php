<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Profile;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Internal\Profile\ProfileResponse;
use Domain\Internal\DataTransferObjects\Profile\ProfileData;
use Illuminate\Http\Request;

/**
 * @group Internal
 *
 * APIs for internal system
 *
 * @subgroup Profile
 *
 * @subgroupDescription get self profile
 */
final class GetSelfProfile extends Controller
{
    /**
     * Get Self Profile - Return account data of current user
     */
    public function __invoke(Request $request): mixed
    {
        $admin = $request->user();
        $admin->load('hub');

        return new ProfileResponse(ProfileData::fromModel($admin, $admin->hub));
    }
}
