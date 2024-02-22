<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderRoute>
 */
class OrderRouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'start_station_id' => Station::factory(),
            'end_station_id' => Station::factory(),
            'total_distance' => fake()->numberBetween(50000, 400000),
            'is_selected' => fake()->boolean(),
        ];
    }
}
