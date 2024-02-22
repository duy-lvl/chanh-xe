<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Order;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Order\AcceptOrderRequest;
use Domain\Partner\Actions\Order\Write\AcceptOrderContract;
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
final class AcceptOrder extends Controller
{
    public function __construct(
        private readonly AcceptOrderContract $acceptOrderAction,
    ) {
    }

    /**
     * Accept order - Update an order status to accepted
     */
    public function __invoke(AcceptOrderRequest $request): mixed
    {
        $code = $request->getCode();
        $image = $request->getImage();
        $this->acceptOrderAction->handle(Auth::id(), $code, $image);

        return response()->make(status: 200, content: "Accepted");
    }
}
