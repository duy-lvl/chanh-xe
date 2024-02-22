<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Order\Write\Implementations;

use App\Exceptions\OrderException;
use App\Models\Order;
use Domain\Partner\Actions\Order\Write\ConfirmOrderContract;
use Domain\Partner\DataTransferObjects\Order\OrderConfirmationData;
use Domain\PriceCalculation\Services\PriceCalculation;
use Domain\Shared\ValueObjects\Distance;
use Illuminate\Support\Facades\DB;

final class ConfirmOrder implements ConfirmOrderContract
{
    public function __construct(
        private PriceCalculation $priceCalculation
    ) {
    }

    public function handle(int $partnerId, OrderConfirmationData $confirmData): void
    {
        DB::transaction(
            callback: function () use ($partnerId, $confirmData): void {
                $order = Order::query()->with(['startStation', 'nextCheckpoint.checkpoint'])
                    ->where('code', $confirmData->code)->firstOrFail();

                $checkpoint = $order->currentCheckpoint->checkpoint;

                if ($checkpoint->partner_id !== $partnerId) {
                    throw OrderException::OrderNotBelongToPartnerException();
                }

                if ($order->is_confirmed) {
                    throw OrderException::OrderHasBeenConfirmedException();
                }

                //update order
                $order->weight = $confirmData->packageWeight->value();
                $order->height = $confirmData->packageDimensions->height();
                $order->length = $confirmData->packageDimensions->length();
                $order->width = $confirmData->packageDimensions->width();
                $order->package_value = $confirmData->packageValue;
                $order->delivery_price = $this->priceCalculation->calculateOrderPrice(
                    weight: $confirmData->packageWeight,
                    dimensions: $confirmData->packageDimensions,
                    distance: new Distance($order->totalDistance),
                    packageValue: $confirmData->packageValue
                );
                $order->is_confirmed = true;
                $order->confirmed_at = now();
                $updateResult = $order->save();
                //check if update successfully or not
                if ( ! $updateResult) {
                    throw OrderException::ConfirmFailedException();
                }
            },
            attempts: 3
        );
    }
}
