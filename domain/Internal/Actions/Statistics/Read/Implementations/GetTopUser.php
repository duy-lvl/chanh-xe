<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Statistics\Read\Implementations;

use App\Models\Customer;
use Domain\Internal\Actions\Statistics\Read\GetTopUserContract;
use Domain\Internal\DataTransferObjects\Statistics\TopCustomerData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class GetTopUser implements GetTopUserContract
{
    /**
     * @return Collection<TopCustomerData>
     */
    public function handle(int $numberOfCustomers = 10): Collection
    {
        $customers = Customer::query()->whereRelation('orders', fn (Builder $query) => 
            $query->whereDoesntHave('routeCheckpoints.permissions', fn (Builder $query) => 
                $query->where('achieved_at', null)
            )
        )->withCount(
            ['orders' => 
                fn (Builder $query) => $query->
                    whereDoesntHave('routeCheckpoints.permissions', 
                        fn (Builder $query) => $query->whereNull('achieved_at'))
            ]
        )
        ->orderByDesc('orders_count')
        ->limit($numberOfCustomers)
        ->get();
        
        return $customers->map(fn (Customer $customer) => TopCustomerData::fromModel($customer, $customer->orders_count));

    }
}
