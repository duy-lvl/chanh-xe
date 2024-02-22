<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Driver;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Driver\DeleteDriverRequest;
use Domain\Partner\Actions\Driver\Write\DeleteDriverContract;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Driver
 *
 * @subgroupDescription Partner Delete Drivers
 */
final class DeleteDriver extends Controller
{
    public function __construct(
        private readonly DeleteDriverContract $deleteDriverAction,
    ) {
    }

    /**
     * Delete Driver - Handle an incoming Delete Driver request from partner.
     */
    public function __invoke(DeleteDriverRequest $request): mixed
    {
        $driverId = $request->getId();
        $result = $this->deleteDriverAction->handle(partnerId: Auth::id(), driverId: $driverId);
        return response()->make(__('messages.partner_driver.deleted'));
    }
}
