<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Profile;

use Illuminate\Http\Request;
use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\CustomerFacing\Profile\ProfileResponse;
use Domain\CustomerFacing\DataTransferObjects\Profile\ProfileData;

/**
 * @group Customer Facing
 *
 * APIs for customer app
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
        return new ProfileResponse(ProfileData::fromModel($request->user()));
    }
}
