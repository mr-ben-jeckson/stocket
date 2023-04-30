<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private function fakeImageObject() {
        $object = (object) [
            'id' => uniqid(),
            'url' => fake()->imageUrl(),
            'mine' => fake()->randomElement(['image/png', 'image/jpg']),
            'storage' => fake()->randomElement(['faker/fake.png', 'faker/fake.jpg']),
            'size' => fake()->randomElement([ 22000, 34500, 19999, 154110 ]),
            'created_at' => now()
        ];
        return $object;
    }

    private function fakeFeatureObject() {
        $object = (object) [
            'head' => fake()->word(),
            'text' => fake()->unique()->word()
        ];
        return $object;
    }

    public function definition()
    {
        return [
            'title' => fake()->text(),
            'images' => json_encode([$this->fakeImageObject(), $this->fakeImageObject(), $this->fakeImageObject()]),
            'description' => fake()->realText(2000),
            'features' => json_encode([$this->fakeFeatureObject(), $this->fakeFeatureObject(), $this->fakeFeatureObject(),$this->fakeFeatureObject()]),
            'price' => fake()->randomFloat(2, 20, 5000),
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1
        ];
    }
}
