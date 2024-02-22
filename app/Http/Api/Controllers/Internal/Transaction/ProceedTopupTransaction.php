<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Transaction;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Transaction\ProceedTopupTransactionRequest;
use Domain\Internal\Actions\Transaction\Write\ProceedTopupTransactionContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Transaction
 *
 * @subgroupDescription Internal manage transaction
 */
final class ProceedTopupTransaction extends Controller
{
    public function __construct(
        private readonly ProceedTopupTransactionContract $proceedTopupTransactionAction,
    ) {
    }

    /**
     * Proceed Transactions - Handle an incoming get transactions request from admin.
     */
    public function __invoke(ProceedTopupTransactionRequest $request): mixed
    {
        $requestId = $request->getRequestId();
        $this->proceedTopupTransactionAction->handle($requestId);
       
        return response()->make(content: 'Success', status: 200);
    }
}
