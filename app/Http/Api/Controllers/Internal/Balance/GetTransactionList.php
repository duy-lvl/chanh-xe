<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Balance;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Balance\GetTransactionRequest;
use App\Http\Api\Responses\Internal\Balance\TransactionResource;
use Domain\Internal\Actions\Balance\Read\GetTransactionListContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Balance
 *
 * @subgroupDescription Admin view application incomes and expenses
 */
final class GetTransactionList extends Controller
{
    public function __construct(
        private readonly GetTransactionListContract $getTransactionListAction,
    ) {
    }

    /**
     * Get Transactions - Handle an incoming get transactions from admin.
     */
    public function __invoke(GetTransactionRequest $request): mixed
    {
        $pagingData = $request->getPagingData();

        $transactions = $this->getTransactionListAction->handle($pagingData);

        return TransactionResource::collection($transactions);
    }
}
