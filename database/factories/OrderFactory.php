<?php

namespace Database\Factories;

use App\Models\Station;
use App\Models\Customer;
use Domain\CustomerFacing\Enums\PackageType;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_station_id' => Station::factory(),
            'end_station_id' => Station::factory(),
            'customer_id' => Customer::factory(),
            'code' => bin2hex(random_bytes(5)),
            'sender_name' => fake()->name(),
            'sender_phone' => fake()->e164PhoneNumber(),
            'sender_email' => fake()->safeEmail(),
            'receiver_name' => fake()->name(),
            'receiver_phone' => fake()->e164PhoneNumber(),
            'receiver_email' => fake()->safeEmail(),
            'note' => fake()->sentence(),
            'package_value' => fake()->numberBetween(20000, 3000000),
            'delivery_price' => fake()->numberBetween(50000, 300000),
            'weight' => fake()->numberBetween(100, 50000),
            'height' => fake()->numberBetween(100, 1000),
            'length' => fake()->numberBetween(100, 1000),
            'width' => fake()->numberBetween(100, 1000),
            'package_types' => fake()->randomElements(PackageType::class),
            'payment_method' => fake()->randomElement(PaymentMethod::class),
            'collect_on_delivery' => fake()->boolean(),
        ];
    }
}
