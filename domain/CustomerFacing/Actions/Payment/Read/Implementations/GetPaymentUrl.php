<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Payment\Read\Implementations;

use App\Models\Order;
use Illuminate\Support\Str;
use App\Exceptions\PaymentException;
use Domain\CustomerFacing\Actions\Payment\Read\GetPaymentUrlContract;
use Domain\CustomerFacing\Enums\PaymentMethod;

final class GetPaymentUrl implements GetPaymentUrlContract
{
    public function handle(?int $customerId, string $orderCode, string $ipAddress): string
    {
        $code = Str::lower($orderCode);

        $order = Order::query()->where("code", $code)->firstOrFail();

        if ($order->payment_method !== PaymentMethod::VnPay) {
            throw PaymentException::ConflictPaymentMethodException();
        }
        if ($order->isPaid) {
            throw PaymentException::OrderHadBeenPaidException();
        }
        if ($order->is_cancelled) {
            throw PaymentException::OrderHasBeenCancelledException();
        }
        if (!$order->is_confirmed) {
            throw PaymentException::OrderNotConfirmedException();
        }
        //metadata
        $vnp_Url = config('services.vnpay.url');

        if ($customerId !== null) {
            $vnp_Returnurl = config('services.vnpay.login_returnUrl') . $code;
        }
        else {
            $vnp_Returnurl = config('services.vnpay.nonLogin_returnUrl') . $code;
        }

        $vnp_TmnCode = config('services.vnpay.tmnCode');
        $vnp_HashSecret = config('services.vnpay.hashSecret');

        $currencyCode = config('services.vnpay.currencyCode');
        $vnp_version = config('services.vnpay.version');
        $vnp_command = 'pay';
        $vnp_CreateDate = date('YmdHis');

        //order data
        $vnp_TxnRef = $code;
        $vnp_OrderInfo = 'Thanh toan hoa don '. $code;
        $vnp_OrderType = 250000;
        $vnp_Amount = (int) $order->delivery_price * 100;
        $vnp_Locale = config('services.vnpay.locale');
        $vnp_IpAddr = $ipAddress;


        $inputData = [
            'vnp_Version' => $vnp_version,
            'vnp_TmnCode' => $vnp_TmnCode,
            'vnp_Amount' => (string)$vnp_Amount,
            'vnp_Command' =>  $vnp_command,
            'vnp_CreateDate' => $vnp_CreateDate,
            'vnp_CurrCode' => $currencyCode,
            'vnp_IpAddr' => $vnp_IpAddr,
            'vnp_Locale' => $vnp_Locale,
            'vnp_OrderInfo' => $vnp_OrderInfo,
            'vnp_OrderType' => (string)$vnp_OrderType,
            'vnp_ReturnUrl' => $vnp_Returnurl,
            'vnp_TxnRef' => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }
}
