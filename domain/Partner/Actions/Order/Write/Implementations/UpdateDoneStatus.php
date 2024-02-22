<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Write\Implementations;

use App\Events\OrderDone;
use App\Exceptions\OrderException;
use App\Models\Order;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\Partner\Actions\Order\Write\UpdateDoneStatusContract;
use Domain\Partner\DataTransferObjects\Transaction\NewTransactionData;
use Domain\Partner\Enums\WalletType;
use Domain\Partner\Services\TransactionManagement;
use Domain\Shared\DataTransferObjects\LocationData;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class UpdateDoneStatus implements UpdateDoneStatusContract
{
    public function __construct(
        private readonly TransactionManagement $partnerTransactionManagementService,
    ) {
    }

    public function handle(int $partnerId, string $orderCode, string $receiveToken, UploadedFile $image): bool
    {
        return DB::transaction(
            callback: function () use ($partnerId, $orderCode, $receiveToken, $image): bool {
                $code = Str::lower($orderCode);

                $order = Order::query()
                    ->with([
                        'endStation',
                        'currentCheckpoint.permissions',
                        'currentCheckpoint.checkpoint',
                        'routeCheckpoints'
                    ])
                    ->where('code', $code)
                    ->firstOrFail();

                if (Str::lower($order->receive_token) !== Str::lower($receiveToken)){
                    throw OrderException::ReceiveTokenNotMatch();
                }

                if ($order->endStation->partner_id !== $partnerId) {
                    throw OrderException::OrderNotBelongToPartnerException();
                }

                $permissions = $order->currentCheckpoint->permissions;

                if ( ! (null !== $permissions->where('permission', OrderStatus::Delivered)->first()?->achieved_at
                    && null === $permissions->where('permission', OrderStatus::Done)->first()?->achieved_at)) {
                    throw OrderException::InvalidOrderStatusException();
                }

                if ( ! $order->canBeDone) {
                    throw OrderException::OrderNotPaidException();
                }

                $this->handlePaymentAndTransaction($partnerId, $order);

                $now = Carbon::now();

                $imageUrl = Storage::disk('s3')->putFile('orders', $image, 'public');
                $order->deliver_image_url = $imageUrl;
                $order->save();


                $updateResult = $order->currentCheckpoint->permissions()
                    ->where('permission', OrderStatus::Done)
                    ->update(['achieved_at' => $now]);

                if (0 === $updateResult) {
                    throw OrderException::UpdateStatusFailedException();
                }

                OrderDone::dispatch(
                    $order,
                    $now->toImmutable(),
                    new LocationData(name: $order->endStation->name, address: $order->endStation->address),
                );

                return true;
            },
            attempts: 3
        );
    }

    private function handlePaymentAndTransaction(int $partnerId, Order $order): void
    {
        //if user pay in cash
        if (PaymentMethod::Cash === $order->payment_method && $order->collect_on_delivery) {
            //create a payment from Customer to Us and a collect on behalf transaction from Partner
            $order->payments()->create([
                'value' => $order->delivery_price,
                'payment_method' => PaymentMethod::Cash,
            ]);

            $this->partnerTransactionManagementService->generateTransaction(
                partnerId: $partnerId,
                type: WalletType::CollectionOnBehalf,
                data: new NewTransactionData(
                    amount: $order->delivery_price,
                    description: __('messages.transaction.collectionOnBehalf', ['orderCode' => Str::upper($order->code)]),
                ),
            );
        }
    }
}
