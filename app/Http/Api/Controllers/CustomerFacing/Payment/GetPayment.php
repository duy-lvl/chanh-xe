<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Payment;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Payment\GetPaymentHistoryRequest;
use App\Http\Api\Responses\CustomerFacing\Payment\PaymentResource;
use Domain\CustomerFacing\Actions\Payment\Read\GetPaymentHistoryContract;
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
final class GetPayment extends Controller
{
    public function __construct(
        private readonly GetPaymentHistoryContract $getPaymentHitoryAction
    ) {
    }

    /**
     * Get payments - Handle an incoming get payments request from customer.
     */
    public function __invoke(GetPaymentHistoryRequest $request): mixed
    {
        $pagingData = $request->getPagingData();
        $payments = $this->getPaymentHitoryAction->handle(Auth::id(), $pagingData);

        return PaymentResource::collection($payments);
    }
}
