<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderDelivered;
use App\Models\Hub;
use App\Models\Order;
use App\Models\Station;
use Domain\Partner\DataTransferObjects\Transaction\NewTransactionData;
use Domain\Partner\Enums\WalletType;
use Domain\Partner\Services\TransactionManagement;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Str;

final class ProcessTransactionForPartner
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly TransactionManagement $partnerTransactionManagementService,
    ) {

    }

    /**
     * Handle the event.
     */
    public function handle(OrderDelivered $event): void
    {
        /** @var Order */
        $order = $event->order;
        $deliverPartnerId = $event->deliverPartnerId;

        // $deliverPartnerId = 1;

        $order->loadMissing('routeCheckpoints.checkpoint');

        $hubNumber = $order->routeCheckpoints->where('checkpoint_type', (new Hub())->getMorphClass())->count();

        $partnerRevenue = 0;

        if (0 === $hubNumber) {
            $partnerRevenue = $order->delivery_price * 0.95; //we get 5%
        } else {
            $hubPercentage = $hubNumber * 0.2; // each hub will be 20%

            $stations = new EloquentCollection($order->routeCheckpoints->pluck('checkpoint')->filter(fn ($checkpoint) => $checkpoint instanceof Station));

            $stations->loadMissing('partner');

            $partners = new EloquentCollection($stations->pluck('partner'));
            $partners = $partners->unique()->values();

            if (1 === $partners->count()) {
                $partnerRevenue = $order->delivery_price * (1 - $hubPercentage);
            } else {
                //TODO: generic solution
                $partnerCut = $order->delivery_price * (1 - $hubPercentage);

                $firstPartnerPercentage = $order->routeCheckpoints[0]->distance_percentage / 100;
                $secondPartnerPercentage = $order->routeCheckpoints[1]->distance_percentage / 100;

                $thisPartnerPercentage = $deliverPartnerId === $partners->first()?->id ? $firstPartnerPercentage : $secondPartnerPercentage;

                $partnerRevenue = $thisPartnerPercentage * $partnerCut;
            }
        }

        $this->partnerTransactionManagementService->generateTransaction(
            partnerId: $deliverPartnerId,
            type: WalletType::Revenue,
            data: new NewTransactionData(
                amount: (int) round($partnerRevenue),
                // description: 'Revenue from order ' . $order->id,
                description: __('messages.transaction.revenueAdded', ['orderCode' => Str::upper($order->code)]),
            ),
        );
    }
}
