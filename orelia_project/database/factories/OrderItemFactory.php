<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Piece;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $unitPrice = fake()->numberBetween(2500, 500000);
        $quantity = fake()->numberBetween(1, 4);

        return [
            'order_id' => Order::factory(),
            'piece_id' => Piece::factory(),
            'unit_price' => $unitPrice,
            'quantity' => $quantity,
            'subtotal' => $unitPrice * $quantity,
        ];
    }
}
