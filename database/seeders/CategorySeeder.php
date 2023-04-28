<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Category::factory(3)->create(); // Ramdom Faker cann't commit the nested column
        Category::create([
            'name' => "Electronic",
            'type' => "main",
            'nested' => 0,
            'locale' => json_encode(['mm' => fake()->randomElement(['အစားအစာခြောက်','အီလက်ထရောနစ်', 'နည်းပညာ']), 'en' => fake()->name()])
        ]);
        Category::create([
            'name' => "Computer & Accessories",
            'type' => "sub",
            'nested' => 1,
            'locale' => json_encode(['mm' => fake()->randomElement(['အစားအစာခြောက်','အီလက်ထရောနစ်', 'နည်းပညာ']), 'en' => fake()->name()])
        ]);
        Category::create([
            'name' => "Laptops",
            'type' => "child",
            'nested' => 2,
            'locale' => json_encode(['mm' => fake()->randomElement(['အစားအစာခြောက်','အီလက်ထရောနစ်', 'နည်းပညာ']), 'en' => fake()->name()])
        ]);
    }
}
