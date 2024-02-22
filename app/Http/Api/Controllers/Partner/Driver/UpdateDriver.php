<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Driver;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Driver\UpdateDriverRequest;
use Domain\Partner\Actions\Driver\Write\UpdateDriverContract;
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
final class UpdateDriver extends Controller
{
    public function __construct(
        private readonly UpdateDriverContract $updateDriverAction
    ) {}

    /**
     * Update Driver - Handle an incoming Update Driver request from partner.
     */
    public function __invoke(UpdateDriverRequest $request): mixed
    {
        $data = $request->getDriverData();

        $this->updateDriverAction->handle(Auth::id(), $data);

        return response()->make(content: __('messages.partner_driver.updated'), status: 200);
    }
}
