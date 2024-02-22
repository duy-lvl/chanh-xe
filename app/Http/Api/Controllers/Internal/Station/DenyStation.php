<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Station;

use App\Http\Api\Controllers\Controller;
use Domain\Internal\Actions\Station\Write\DenyStationContract;
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
final class DenyStation extends Controller
{
    public function __construct(
        
        private readonly DenyStationContract $denyStationAction,
    ) {
    }

    /**
     * Deny create Station - Handle an incoming deny create station request from admin.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request, int $id): mixed
    {
        $isSuccess = $this->denyStationAction->handle($id);
        if (!$isSuccess) {
            return abort(code:500, message: "Deny failed");
        }
        return response()->make(content: "Success", status:200);
    }
}