<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_id' => User::factory()->client(),
            'total' => 0, // recalculated after items are attached in the seeder
            'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'payment_method' => fake()->randomElement(['credit_card', 'debit_card', 'paypal', 'bank_transfer']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed', 'refunded']),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'delivered',
            'payment_status' => 'paid',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'payment_status' => fake()->randomElement(['refunded', 'failed']),
        ]);
    }
}
