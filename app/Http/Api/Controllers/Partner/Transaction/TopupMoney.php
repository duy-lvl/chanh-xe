<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Transaction;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Station\WithdrawRequest;
use App\Http\Api\Requests\Partner\Transaction\TopupRequest;
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
final class TopupMoney extends Controller
{
    public function __construct(
        private readonly CreateTransactionRequestContract $createTransactionRequestAction,
    ) {
    }

    /**
     * Create top-up Transactions - Handle an incoming create top-up transactions request from partner.
     */
    public function __invoke(TopupRequest $request): mixed
    {
        $amount = $request->getAmount();
        $image = $request->getImage();
        $result = $this->createTransactionRequestAction->handle(
            partnerId: Auth::id(), 
            amount: $amount, 
            type: TransactionRequestType::Topup,
            image: $image
        );
        if (!$result) {
            return abort(code: 500, message: "Failed. Server error");
        }
        return response()->make(content: "Created successfully", status: 201);
    }
}
