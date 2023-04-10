<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'type' => fake()->randomElement(['main','sub','child']),
            'nested' => fake()->randomElement([0, 1, 2]),
            'locale' => json_encode(['mm' => fake()->randomElement(['အစားအစာခြောက်','အီလက်ထရောနစ်', 'နည်းပညာ']), 'en' => fake()->name()])
        ];
    }
}
