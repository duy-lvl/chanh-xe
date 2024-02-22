<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Route;
use App\Models\Station;
use Carbon\Carbon;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

final class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stations = Station::all();
        $orders = Order::factory()
            ->count(100)
            ->recycle($stations)
            ->create();

        $routes = Route::with('milestones')->get();

        foreach ($orders as $order) {

            $coinFlip = fake()->boolean();

            if ($coinFlip) {
                Payment::factory()->create(
                    [
                        'payment_method' => $order->payment_method,
                        'order_id' => $order->id,
                        'value' => $order->delivery_price,
                        'vnpay_transaction_code' => PaymentMethod::Cash === $order->payment_method ? null : Str::upper(Str::password(length: 11, symbols: false)),
                    ]
                );
            }
            $this->createCheckpoints($order, $routes);
        }

    }

    private function createCheckpoints(Order $order, Collection $routes): void
    {
        $route = $routes->random();
        [$startMilestone, $endMilestone] = $route->milestones->random(2)->sortBy('milestone_number');
        [$checkpoint1, $checkpoint2] = $order->routeCheckpoints()->createMany([
            [
                'checkpoint_id' => $startMilestone->station_id,
                'checkpoint_type' => (new Station())->getMorphClass(),
                'distance_from_previous' => 0,
                'distance_percentage' => 0,
                'checkpoint_number' => 1,
            ],
            [
                'checkpoint_id' => $endMilestone->station_id,
                'checkpoint_type' => (new Station())->getMorphClass(),
                'distance_from_previous' => $route->milestones->whereBetween('milestone_number', [$startMilestone->milestone_number + 1, $endMilestone->milestone_number])->sum('distance_from_previous'),
                'distance_percentage' => 100,
                'checkpoint_number' => 2,
            ],
        ]);

        $progress = rand(0, 4);

        $time = Carbon::now();

        $checkpoint1->permissions()->create(
            [
                'permission' => OrderStatus::Accepted,
                'permission_number' => 1,
                'achieved_at' => $progress < 1 ? null : $time->addHours(rand(1, 3)),
            ],
            [
                'permission' => OrderStatus::Delivering,
                'permission_number' => 2,
                'achieved_at' => $progress < 2 ? null : $time->addHours(rand(4, 5)),
            ],
        );
        $checkpoint2->permissions()->create(
            [
                'permission' => OrderStatus::Delivered,
                'permission_number' => 1,
                'achieved_at' => $progress < 3 ? null : $time->addDay(),
            ],
            [
                'permission' => OrderStatus::Done,
                'permission_number' => 2,
                'achieved_at' => $progress < 4 ? null : $time->addDays(rand(1, 2)),
            ],
        );
    }
}
