<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder {
    public function run(): void {
        $categories = [
            ['name' => 'Breakfast', 'slug' => 'breakfast', 'description' => 'Start your day right'],
            ['name' => 'Lunch',     'slug' => 'lunch',     'description' => 'Midday meals'],
            ['name' => 'Dinner',    'slug' => 'dinner',    'description' => 'Evening dishes'],
            ['name' => 'Desserts',  'slug' => 'desserts',  'description' => 'Sweet treats'],
            ['name' => 'Snacks',    'slug' => 'snacks',    'description' => 'Quick bites'],
            ['name' => 'Drinks',    'slug' => 'drinks',    'description' => 'Beverages and smoothies'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}