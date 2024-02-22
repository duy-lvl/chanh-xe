<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Profile;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\Partner\Profile\ProfileResponse;
use App\Models\PartnerPhone;
use Domain\Partner\DataTransferObjects\Profile\ProfileData;
use Illuminate\Http\Request;

/**
 * @group Partner
 *
 * APIs for partner app
 *
 * @subgroup Profile
 *
 * @subgroupDescription get self profile
 */
final class GetSelfProfile extends Controller
{
    /**
     * Get Self Profile - Return account data of current partner
     */
    public function __invoke(Request $request): mixed
    {
        $account = $request->user();
        $account->load('phones');

        $phones = $account->phones->map(fn (PartnerPhone $phone): string => $phone->phone);
        
        return new ProfileResponse(ProfileData::fromModel($account, $phones));
    }
}
