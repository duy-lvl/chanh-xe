<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Transaction;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Transaction\GetTransactionRequestRequest;
use App\Http\Api\Responses\Internal\Transaction\GetTransactionRequestResource;
use Domain\Internal\Actions\Transaction\Read\GetTransactionRequestContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Transaction
 *
 * @subgroupDescription Internal manage transaction
 */
final class GetTransactionRequestList extends Controller
{
    public function __construct(
        private readonly GetTransactionRequestContract $getTransactionRequestAction,
    ) {
    }

    /**
     * Get Transactions - Handle an incoming get transactions request from admin.
     */
    public function __invoke(GetTransactionRequestRequest $request): mixed
    {
        $pagingData = $request->getPagingData();

        $transactionRequests = $this->getTransactionRequestAction->handle($pagingData);

        return GetTransactionRequestResource::collection($transactionRequests);
    }
}
