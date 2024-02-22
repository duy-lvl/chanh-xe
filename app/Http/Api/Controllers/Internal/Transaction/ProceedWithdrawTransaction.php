<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Internal\Transaction;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Internal\Transaction\ProceedWithdrawTransactionRequest;
use Domain\Internal\Actions\Transaction\Write\ProceedWithdrawTransactionContract;

/**
 * @group Internal
 *
 * APIs for Internal system
 *
 * @subgroup Transaction
 *
 * @subgroupDescription Internal manage transaction
 */
final class ProceedWithdrawTransaction extends Controller
{
    public function __construct(
        private readonly ProceedWithdrawTransactionContract $proceedWithdrawTransactionAction,
    ) {
    }

    /**
     * Proceed Transactions - Handle an incoming get transactions request from admin.
     */
    public function __invoke(ProceedWithdrawTransactionRequest $request): mixed
    {
        $requestId = $request->getRequestId();
        $image = $request->getImage();
        $this->proceedWithdrawTransactionAction->handle($requestId, $image);
       
        return response()->make(content: 'Success', status: 200);
    }
}
