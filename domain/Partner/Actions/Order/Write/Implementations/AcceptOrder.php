<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Write\Implementations;

use App\Events\OrderAccepted;
use App\Exceptions\OrderException;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Partner;
use App\Models\Payment;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Domain\Partner\Actions\Order\Write\AcceptOrderContract;
use Domain\Partner\DataTransferObjects\Transaction\NewTransactionData;
use Domain\Partner\Enums\WalletType;
use Domain\Partner\Services\TransactionManagement;
use Domain\Shared\DataTransferObjects\LocationData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class AcceptOrder implements AcceptOrderContract
{
    public function __construct(
        private readonly TransactionManagement $partnerTransactionManagementService,
    ) {
    }

    public function handle(int $partnerId, string $orderCode, UploadedFile $image): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $orderCode, $image): void {
                $code = Str::lower($orderCode);

                $order = Order::query()->with(['startStation'])->where('code', $code)->firstOrFail();

                $firstCheckpoint = $order->routeCheckpoints()
                    ->where('checkpoint_number', 1)
                    ->whereHas('permissions', function (Builder $query): void {
                        $query->where('achieved_at', null)->where('permission', OrderStatus::Accepted);
                    })->first();

                if (null === $firstCheckpoint) {
                    throw OrderException::ConfirmFailedException();
                }

                if ($order->startStation->partner_id !== $partnerId) {
                    throw OrderException::OrderNotBelongToPartnerException();
                }

                if ( ! $order->is_confirmed) {
                    throw OrderException::OrderHasNotBeenConfirmedException();
                }

                if ( ! $order->canBeAccepted) {
                    throw OrderException::OrderNotPaidException();
                }

                $this->handlePaymentAndTransaction($partnerId, $order);

                $imageUrl = Storage::disk('s3')->putFile('orders', $image, 'public');
                $order->package_image_url = $imageUrl;
                $order->save();
                
                $now = Carbon::now();
                
                $updateResult = $firstCheckpoint->permissions()
                    ->where('permission', OrderStatus::Accepted)
                    ->update(['achieved_at' => $now]);

                if (0 === $updateResult) {
                    throw OrderException::UpdateStatusFailedException();
                }

                OrderAccepted::dispatch(
                    $order,
                    $now->toImmutable(),
                    new LocationData(name: $order->startStation->name, address: $order->startStation->address),
                );
            },
            attempts: 3
        );
    }

    private function handlePaymentAndTransaction(int $partnerId, Order $order): void
    {
        if (PaymentMethod::Cash === $order->payment_method && ! $order->collect_on_delivery) {
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
