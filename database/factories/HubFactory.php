<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hub>
 */
class HubFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $latitude = fake()->latitude();
        $longitude = fake()->longitude();

        return [
            'name' => fake()->company(),
            'address' => fake()->address(),
            'latitude' => $latitude,
            'longitude' => $longitude,
            'geography' => Point::makeGeodetic(latitude: $latitude, longitude: $longitude),
        ];
    }
}
