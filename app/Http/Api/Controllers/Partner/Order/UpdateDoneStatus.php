<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Order\UpdateDoneStatusRequest;
use Domain\Partner\Actions\Order\Write\UpdateDoneStatusContract;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Order
 *
 * @subgroupDescription Order interactions
 */
final class UpdateDoneStatus extends Controller
{
    public function __construct(
        private readonly UpdateDoneStatusContract $updateDoneStatusAction,
    ) {
    }

    /**
     * Done - Update an order's status to Done
     */
    public function __invoke(UpdateDoneStatusRequest $request): mixed
    {
        $this->updateDoneStatusAction->handle(
            partnerId: Auth::id(),
            orderCode: $request->getCode(),
            receiveToken: $request->getReceiveToken(),
            image: $request->getImage(),
        );

        return response()->make(status: 200, content: 'Update successfully');
    }
}
