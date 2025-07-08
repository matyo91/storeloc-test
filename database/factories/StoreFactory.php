<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => rtrim(fake()->text(25), '.'),
            'lat' => fake()->randomFloat(null, 48.12, 49.24),
            'lng' => fake()->randomFloat(null, 1.45, 3.56),
            'address' => fake()->numberBetween(1, 100) . ' rue ' . fake()->name(),
            'city' => ucfirst(fake()->word),
            'zipcode' => collect([75, 91, 92, 93, 94, 95])->random() . rand(10, 99) . '0',
            'country_code' => 'FR',
            'hours' => [
                'Monday' => ['14:00-18:00'],
                'Tuesday' => ['08:00-12:00', '14:00-18:00'],
                'Wednesday' => ['08:00-12:00', '14:00-18:00'],
                'Thursday' => ['08:00-12:00', '14:00-18:00'],
                'Friday' => ['08:00-12:00', '14:00-18:00'],
                'Saturday' => ['08:00-12:00'],
            ],
        ];
    }
}
