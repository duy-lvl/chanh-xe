<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Balance;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Balance\GetPaymentRequest;
use App\Http\Api\Responses\Internal\Balance\PaymentResource;
use Domain\Internal\Actions\Balance\Read\GetPaymentListContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Balance
 *
 * @subgroupDescription Admin view application incomes and expenses
 */
final class GetPaymentList extends Controller
{
    public function __construct(
        private readonly GetPaymentListContract $getPaymentListAction,
    ) {
    }

    /**
     * Get Payments - Handle an incoming get Payments from admin.
     */
    public function __invoke(GetPaymentRequest $request): mixed
    {
        $pagingData = $request->getPagingData();

        $Payments = $this->getPaymentListAction->handle($pagingData);

        return PaymentResource::collection($Payments);
    }
}
