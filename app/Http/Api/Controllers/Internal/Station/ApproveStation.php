<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Station;

use App\Http\Api\Controllers\Controller;
use Domain\Internal\Actions\Station\Write\ApproveStationContract;
use Illuminate\Http\Request;

/**
 * @group Internal
 *
 * APIs for Admin system
 *
 * @subgroup Station
 *
 * @subgroupDescription Admin get stations
 */
final class ApproveStation extends Controller
{
    public function __construct(
        
        private readonly ApproveStationContract $approveStationAction,
    ) {
    }

    /**
     * Approve Station - Handle an incoming approve create station request from admin.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request, int $id): mixed
    {
        $isSuccess = $this->approveStationAction->handle($id);
        if (!$isSuccess) {
            return abort(code:500, message: "Approve failed");
        }
        return response()->make(content: "Success", status:200);
    }
}