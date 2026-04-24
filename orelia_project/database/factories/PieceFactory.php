<?php

namespace Database\Factories;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class PieceFactory extends Factory
{
    private static array $typeData = [
        'ring' => [
            'names' => ['Solitaire Ring', 'Band Ring', 'Signet Ring', 'Eternity Ring', 'Statement Ring', 'Stackable Ring'],
            'sizes' => ['5', '6', '7', '8', '9', '10', '11'],
            'weight' => [2.0, 12.0],
        ],
        'necklace' => [
            'names' => ['Pendant Necklace', 'Chain Necklace', 'Choker', 'Lariat', 'Collar Necklace', 'Y-Necklace'],
            'sizes' => ['14"', '16"', '18"', '20"', '22"', '24"'],
            'weight' => [5.0, 35.0],
        ],
        'bracelet' => [
            'names' => ['Tennis Bracelet', 'Bangle', 'Charm Bracelet', 'Cuff Bracelet', 'Chain Bracelet', 'Wrap Bracelet'],
            'sizes' => ['6"', '6.5"', '7"', '7.5"', '8"'],
            'weight' => [8.0, 40.0],
        ],
        'earring' => [
            'names' => ['Stud Earrings', 'Hoop Earrings', 'Drop Earrings', 'Huggie Earrings', 'Dangle Earrings', 'Ear Climbers'],
            'sizes' => ['small', 'medium', 'large', '10mm', '20mm', '30mm'],
            'weight' => [1.0, 15.0],
        ],
        'pendant' => [
            'names' => ['Heart Pendant', 'Cross Pendant', 'Initial Pendant', 'Birthstone Pendant', 'Charm Pendant'],
            'sizes' => ['small', 'medium', 'large'],
            'weight' => [3.0, 20.0],
        ],
        'brooch' => [
            'names' => ['Floral Brooch', 'Vintage Brooch', 'Animal Brooch', 'Art Deco Brooch', 'Geometric Brooch'],
            'sizes' => ['small', 'medium', 'large'],
            'weight' => [5.0, 30.0],
        ],
    ];

    public function definition(): array
    {
        $type = fake()->randomElement(array_keys(self::$typeData));
        $typeInfo = self::$typeData[$type];

        // Price stored as integer (cents). Range: $25.00 – $5,000.00
        $price = fake()->numberBetween(2500, 500000);

        return [
            'name' => fake()->randomElement($typeInfo['names']),
            'description' => fake()->paragraph(2),
            'price' => $price,
            'type' => $type,
            'image_url' => null,
            'stock' => fake()->numberBetween(0, 50),
            'size' => fake()->optional(0.85)->randomElement($typeInfo['sizes']),
            'weight' => fake()->randomFloat(2, $typeInfo['weight'][0], $typeInfo['weight'][1]),
            'collection_id' => Collection::factory(),
        ];
    }

    public function ring(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'ring',
            'size' => fake()->randomElement(self::$typeData['ring']['sizes']),
            'weight' => fake()->randomFloat(2, 2.0, 12.0),
        ]);
    }

    public function necklace(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'necklace',
            'size' => fake()->randomElement(self::$typeData['necklace']['sizes']),
            'weight' => fake()->randomFloat(2, 5.0, 35.0),
        ]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }

    public function inStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => fake()->numberBetween(5, 50),
        ]);
    }
}
