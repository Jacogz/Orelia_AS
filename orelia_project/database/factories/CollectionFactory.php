<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CollectionFactory extends Factory
{
    private static array $collectionNames = [
        'Celestial Dreams', 'Wild Bloom', 'Eternal Gold', 'Ocean Whisper',
        'Midnight Garden', 'Solar Flare', 'Desert Rose', 'Arctic Ice',
        'Velvet Noir', 'Spring Awakening', 'Lunar Tide', 'Terra Firma',
        'Golden Hour', 'Starfall', 'Ivory Grace', 'Ember Glow',
        'Sapphire Skies', 'Crimson Haze', 'Forgotten Forest', 'Urban Edge',
    ];

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(self::$collectionNames),
            'description' => fake()->paragraph(2),
        ];
    }
}
