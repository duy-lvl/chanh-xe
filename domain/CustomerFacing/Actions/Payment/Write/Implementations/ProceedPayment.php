<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Payment\Write\Implementations;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\CustomerFacing\DataTransferObjects\Payment\VnPayReturnData;
use Domain\CustomerFacing\Actions\Payment\Write\ProceedPaymentContract;

final class ProceedPayment implements ProceedPaymentContract
{
    public function handle(VnPayReturnData $vnPayReturnData): mixed
    {

        $inputData = (array)$vnPayReturnData;

        $returnData = array();
        $vnp_HashSecret = config('services.vnpay.hashSecret');
        $orderCode = Str::lower($vnPayReturnData->vnp_TxnRef);

        $secureHash = $vnPayReturnData->getHash($vnp_HashSecret);

        $vnp_Amount = ((int) $vnPayReturnData->vnp_Amount)/100;

        if ($secureHash != $vnPayReturnData->vnp_SecureHash) {
            return [
                'RspCode' => '97',
                'Message' => 'Invalid signature',
            ];
        }

        $order = Order::query()->where('code', $orderCode)->first();

        if ($order === null) {
            return [
                'RspCode' => '01',
                'Message' => 'Order not found',
            ];
        }

        if($order->delivery_price != $vnp_Amount){
            return [
                'RspCode' => '04',
                'Message' => 'invalid amount',
            ];
        }

        if ($vnPayReturnData->vnp_ResponseCode != '00' || $vnPayReturnData->vnp_TransactionStatus != '00') {
            return [
                'RspCode' => '99',
                'Message' => 'Unknow error',
            ];
        }


        $updateResult = DB::transaction(
            callback: function () use ($order, $vnPayReturnData): bool {

                return $order
                    ->payments()
                    ->create(
                        [
                            'vnpay_transaction_code' => $vnPayReturnData->vnp_TransactionNo,
                            'payment_method' => PaymentMethod::VnPay,
                            'value' => $vnPayReturnData->vnp_Amount / 100,

                        ]
                    ) !== null;
            },
            attempts: 3
        );

        if ($updateResult)
        {
            $returnData['RspCode'] = '00';
            $returnData['Message'] = 'Confirm Success';
        }
        else
        {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }

        return $returnData;

    }
}
