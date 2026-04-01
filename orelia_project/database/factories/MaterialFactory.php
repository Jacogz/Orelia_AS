<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'type' => $this->faker->randomElement(['ring', 'necklace', 'bracelet', 'earring']),
            'stock' => $this->faker->numberBetween(0, 100),
            'collection_id' => \App\Models\Collection::factory(),

        ];
    }
}
