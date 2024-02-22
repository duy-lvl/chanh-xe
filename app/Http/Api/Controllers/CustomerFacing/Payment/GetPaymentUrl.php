<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Payment;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Responses\CustomerFacing\Payment\GetPaymentUrlResource;
use Domain\CustomerFacing\Actions\Payment\Read\GetPaymentUrlContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Payment
 *
 * @subgroupDescription Customer Payment
 */
final class GetPaymentUrl extends Controller
{
    public function __construct(
        private readonly GetPaymentUrlContract $getPaymentUrlAction
    ) {
    }

    /**
     * Customer pay order - Handle an incoming pay order request from customer.
     */
    public function __invoke(Request $request, string $code): mixed
    {
        $url = $this->getPaymentUrlAction->handle(Auth::guard('api_customer')->id(), $code, $request->ip());

        return new GetPaymentUrlResource($url);
    }
}
