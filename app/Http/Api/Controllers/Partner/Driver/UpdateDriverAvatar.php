<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Driver;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Driver\UpdateDriverAvatarRequest;
use Domain\Partner\Actions\Driver\Write\UpdateDriverAvatarContract;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for partner app
 *
 * @subgroup Driver
 *
 * @subgroupDescription Driver management
 */
final class UpdateDriverAvatar extends Controller
{
    public function __construct(
        private readonly UpdateDriverAvatarContract $updateDriverAvatarAction
    ) {}

    /**
     * Update Self Avatar
     */
    public function __invoke(UpdateDriverAvatarRequest $request): mixed
    {
        $avatar = $request->getDriverImage();
        $driverId = $request->getDriverId();

        $this->updateDriverAvatarAction->handle(Auth::id(), $driverId, $avatar);

        return response()->make(content: "Avatar has been updated", status: 200);
    }
}
