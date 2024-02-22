<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Payment;

use App\Http\Api\Controllers\Controller;
use Domain\CustomerFacing\Actions\Payment\Write\ProceedPaymentContract;
use Domain\CustomerFacing\DataTransferObjects\Payment\VnPayReturnData;
use Illuminate\Http\Request;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Payment
 *
 * @subgroupDescription Customer Payment
 */
final class ProceedPayment extends Controller
{
    public function __construct(
        private readonly ProceedPaymentContract $proceedPaymentAction
    ) {
    }

    /**
     * Handle return result from VnPay
     */
    public function __invoke(Request $request): mixed
    {
        $validated = $request->all();//validated();

        $vnpayReturnData = new VnPayReturnData(
            vnp_Amount: $validated['vnp_Amount'],
            vnp_BankCode: $validated['vnp_BankCode'],
            vnp_BankTranNo: $validated['vnp_BankTranNo'],
            vnp_CardType: $validated['vnp_CardType'],
            vnp_OrderInfo: $validated['vnp_OrderInfo'],
            vnp_PayDate: $validated['vnp_PayDate'],
            vnp_ResponseCode: $validated['vnp_ResponseCode'],
            vnp_TmnCode: $validated['vnp_TmnCode'],
            vnp_TransactionNo: $validated['vnp_TransactionNo'],
            vnp_TransactionStatus: $validated['vnp_TransactionStatus'],
            vnp_TxnRef: $validated['vnp_TxnRef'],
            vnp_SecureHash: $validated['vnp_SecureHash']
        );

        $result = $this->proceedPaymentAction->handle($vnpayReturnData);

        return response()->make($result);
    }
}
