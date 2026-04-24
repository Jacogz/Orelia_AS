<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    // Curated pool of realistic jewelry materials
    private static array $materials = [
        ['name' => 'Yellow Gold',    'type' => 'metal',    'color' => 'yellow'],
        ['name' => 'White Gold',     'type' => 'metal',    'color' => 'white'],
        ['name' => 'Rose Gold',      'type' => 'metal',    'color' => 'rose'],
        ['name' => 'Sterling Silver', 'type' => 'metal',    'color' => 'silver'],
        ['name' => 'Platinum',       'type' => 'metal',    'color' => 'silver'],
        ['name' => 'Titanium',       'type' => 'metal',    'color' => 'gray'],
        ['name' => 'Bronze',         'type' => 'metal',    'color' => 'brown'],
        ['name' => 'Copper',         'type' => 'metal',    'color' => 'orange'],
        ['name' => 'Diamond',        'type' => 'gemstone', 'color' => 'white'],
        ['name' => 'Ruby',           'type' => 'gemstone', 'color' => 'red'],
        ['name' => 'Sapphire',       'type' => 'gemstone', 'color' => 'blue'],
        ['name' => 'Emerald',        'type' => 'gemstone', 'color' => 'green'],
        ['name' => 'Amethyst',       'type' => 'gemstone', 'color' => 'purple'],
        ['name' => 'Topaz',          'type' => 'gemstone', 'color' => 'blue'],
        ['name' => 'Opal',           'type' => 'gemstone', 'color' => 'multicolor'],
        ['name' => 'Turquoise',      'type' => 'gemstone', 'color' => 'turquoise'],
        ['name' => 'Garnet',         'type' => 'gemstone', 'color' => 'red'],
        ['name' => 'Pearl',          'type' => 'organic',  'color' => 'white'],
        ['name' => 'Coral',          'type' => 'organic',  'color' => 'pink'],
        ['name' => 'Amber',          'type' => 'organic',  'color' => 'yellow'],
        ['name' => 'Swarovski Crystal', 'type' => 'crystal', 'color' => 'clear'],
        ['name' => 'Quartz',         'type' => 'crystal',  'color' => 'clear'],
        ['name' => 'Resin',          'type' => 'synthetic', 'color' => 'multicolor'],
        ['name' => 'Enamel',         'type' => 'synthetic', 'color' => 'multicolor'],
    ];

    public function definition(): array
    {
        $material = fake()->unique()->randomElement(self::$materials);

        return [
            'name' => $material['name'],
            'type' => $material['type'],
            'color' => $material['color'],
            'description' => fake()->sentence(),
        ];
    }

    public function metal(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'metal',
        ]);
    }

    public function gemstone(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'gemstone',
        ]);
    }
}
