<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Write\Implementations;

use App\Events\OrderCancelled;
use App\Exceptions\OrderException;
use App\Models\Order;
use App\Models\Partner;
use Domain\Partner\Actions\Order\Write\CancelOrderContract;
use Domain\Partner\DataTransferObjects\Transaction\NewTransactionData;
use Domain\Partner\Enums\WalletType;
use Domain\Partner\Services\TransactionManagement;
use Domain\Shared\DataTransferObjects\LocationData;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class CancelOrder implements CancelOrderContract
{
    public function __construct(
        private readonly TransactionManagement $partnerTransactionManagementService,
    ) {
    }

    public function handle(int $partnerId, string $orderCode, string $reason): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $orderCode, $reason): void {
                $code = Str::lower($orderCode);

                $order = Order::query()->with(['startStation', 'endStation'])->where('code', $code)->firstOrFail();


                if ($order->startStation->partner_id !== $partnerId && $order->endStation->partner_id !== $partnerId) {
                    throw OrderException::OrderNotBelongToPartnerException();
                }
                if ($order->is_lost) {
                    throw OrderException::OrderHasBeenLostException();
                }
                if ($order->package_value > 0) {
                    $this->handlePaymentAndTransaction($partnerId, $order);
                }

                $now = Carbon::now();

                $order->is_cancelled = true;
                $order->cancelled_reason = $reason;
                $order->cancelled_at = $now;
                $order->is_lost = true;
                $order->lost_incharge_id = $partnerId;
                $order->lost_incharge_type = (new Partner())->getMorphClass();
                $order->save();

                $station = $order->startStation->partner_id === $partnerId ? $order->startStation : $order->endStation;
                OrderCancelled::dispatch(
                    $order,
                    $now->toImmutable(),
                    new LocationData(name: $station->name, address: $station->address),
                    $reason
                );
            },
            attempts: 3
        );
    }

    private function handlePaymentAndTransaction(int $partnerId, Order $order): void
    {
        $this->partnerTransactionManagementService->generateTransaction(
            partnerId: $partnerId,
            type: WalletType::Cash,
            data: new NewTransactionData(
                amount: -($order->package_value),
                description: __('messages.transaction.lostOrderPunishment', ['orderCode' => Str::upper($order->code)]),
            ),
        );

    }
}
