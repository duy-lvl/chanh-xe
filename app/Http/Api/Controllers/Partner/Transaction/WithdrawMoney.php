<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Transaction;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Transaction\WithdrawRequest;
use Domain\Partner\Actions\Transaction\Write\CreateTransactionRequestContract;
use Domain\Partner\Enums\TransactionRequestType;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner
 *
 * APIs for Partner system
 *
 * @subgroup Transaction
 *
 * @subgroupDescription Partner get transaction
 */
final class WithdrawMoney extends Controller
{
    public function __construct(
        private readonly CreateTransactionRequestContract $createTransactionRequestAction,
    ) {
    }

    /**
     * Create withdraw Transactions - Handle an incoming create withdraw transactions request from partner.
     */
    public function __invoke(WithdrawRequest $request): mixed
    {
        $amount = $request->getAmount();
        $result = $this->createTransactionRequestAction->handle(
            partnerId: Auth::id(), 
            amount: $amount, 
            type: TransactionRequestType::Withdraw
        );
        if (!$result) {
            return abort(code: 500, message: "Failed. Server error");
        }
        return response()->make(content: "Created successfully", status: 201);
    }
}
