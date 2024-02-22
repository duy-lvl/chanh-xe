<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\DataTransferObjects\Payment;

use Illuminate\Support\Arr;

final readonly class VnPayReturnData
{
    public function __construct(
        public string $vnp_Amount,
        public string $vnp_BankCode,
        public string $vnp_BankTranNo,
        public string $vnp_CardType,
        public string $vnp_OrderInfo,
        public string $vnp_PayDate,
        public string $vnp_ResponseCode,
        public string $vnp_TmnCode,
        public string $vnp_TransactionNo,
        public string $vnp_TransactionStatus,
        public string $vnp_TxnRef,
        public string $vnp_SecureHash,
    ) {
    }

    public function toDataArray(): array
    {
        return [
            'vnp_Amount' => $this->vnp_Amount,
            'vnp_BankCode' => $this->vnp_BankCode,
            'vnp_BankTranNo' => $this->vnp_BankTranNo,
            'vnp_CardType' => $this->vnp_CardType,
            'vnp_OrderInfo' => $this->vnp_OrderInfo,
            'vnp_PayDate' => $this->vnp_PayDate,
            'vnp_ResponseCode' => $this->vnp_ResponseCode,
            'vnp_TmnCode' => $this->vnp_TmnCode,
            'vnp_TransactionNo' => $this->vnp_TransactionNo,
            'vnp_TransactionStatus' => $this->vnp_TransactionStatus,
            'vnp_TxnRef' => $this->vnp_TxnRef,
        ];
    }

    public function getHash(string $hashSecret): string
    {
        
        return hash_hmac('sha512', $this->toHashData(), $hashSecret);
    }

    public function toHashData(): string {
        $input = $this->toDataArray();
        ksort($input);
        $i = 0;
        $hashData = "";
        foreach ($input as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        return $hashData;
    }
}
