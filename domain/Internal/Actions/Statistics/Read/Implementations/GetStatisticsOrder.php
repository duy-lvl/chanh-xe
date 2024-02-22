<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read\Implementations;

use App\Models\Hub;
use App\Models\Order;
use Domain\Internal\Actions\Statistics\Read\GetStatisticsOrderContract;
use Domain\Internal\DataTransferObjects\Statistics\HubOrderData;
use Domain\Internal\DataTransferObjects\Statistics\OrderData;
use Illuminate\Database\Eloquent\Builder;

final class GetStatisticsOrder implements GetStatisticsOrderContract
{
    public function handle(): OrderData
    {
        $numberOfStraightOrders = Order::query()->whereDoesntHave('routeCheckpoints', fn (Builder $query) => 
            $query->where('checkpoint_type', (new Hub())->getMorphClass())
        )
        ->whereDoesntHave('routeCheckpoints.permissions', fn (Builder $query) => 
                $query->where('achieved_at', null)
        )->count();
        $hubs = Hub::query()->get();
        $hubOrders = collect();
        foreach($hubs as $hub) {
            $numberOfOrders = Order::query()->whereHas('routeCheckpoints', fn (Builder $query) => 
                $query->where('checkpoint_type', (new Hub())->getMorphClass())
                    ->where('checkpoint_id', $hub->id)
            )
            ->whereDoesntHave('routeCheckpoints.permissions', fn (Builder $query) => 
                    $query->where('achieved_at', null)
            )->count();
            
            $hubOrders->push(
                HubOrderData::fromModel($hub, $numberOfOrders)
            );
        }
        return new OrderData($numberOfStraightOrders, $hubOrders);

    }
}
