<?php

declare(strict_types=1);

namespace Domain\Partner\Services;

use App\Models\Hub;
use App\Models\Order;
use App\Models\Station;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
final class CalculateRevenue
{
    public function calculateRevenue(Order $order, int $partnerId): int
    {
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

                $firstPartnerPercentage = $order->routeCheckpoints->firstWhere('checkpoint_number', 2)->distance_percentage / 100;
                $secondPartnerPercentage = $order->routeCheckpoints->firstWhere('checkpoint_number', 3)->distance_percentage / 100;

                $thisPartnerPercentage = $partnerId === $partners->first()?->id ? $firstPartnerPercentage : $secondPartnerPercentage;

                $partnerRevenue = $thisPartnerPercentage * $partnerCut;
                
            }
        }
        return (int) round($partnerRevenue);
    }
}
