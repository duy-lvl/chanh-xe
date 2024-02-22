<?php

namespace Database\Factories;

use App\Models\Hub;
use App\Models\OrderRoute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderRoute>
 */
class OrderRouteSegmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_route_id' => OrderRoute::factory(),
            'hub_id' => Hub::factory(),
            'distance' => fake()->numberBetween(50000, 300000),
            'sequence_number' => fake()->numberBetween(1,5),
        ];
    }
}
