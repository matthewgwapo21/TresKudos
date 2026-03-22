<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Step;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RecipeSeeder extends Seeder {
    public function run(): void {

        $admin = User::first();

        $recipes = [
            [
                'title'       => 'Classic Spaghetti Carbonara',
                'description' => 'A rich and creamy Italian pasta dish made with eggs, cheese, pancetta, and pepper. Simple yet incredibly satisfying.',
                'category'    => 'Dinner',
                'prep_time'   => 10,
                'cook_time'   => 20,
                'image_url'   => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=800',
                'ingredients' => [
                    ['quantity' => '400', 'unit' => 'g',   'name' => 'Spaghetti'],
                    ['quantity' => '200', 'unit' => 'g',   'name' => 'Pancetta or bacon'],
                    ['quantity' => '4',   'unit' => '',    'name' => 'Egg yolks'],
                    ['quantity' => '100', 'unit' => 'g',   'name' => 'Pecorino Romano cheese'],
                    ['quantity' => '2',   'unit' => 'tsp', 'name' => 'Black pepper'],
                    ['quantity' => '1',   'unit' => 'tsp', 'name' => 'Salt'],
                ],
                'steps' => [
                    'Boil a large pot of salted water and cook spaghetti until al dente.',
                    'While pasta cooks, fry the pancetta in a pan over medium heat until crispy.',
                    'In a bowl, whisk together egg yolks, grated cheese, and black pepper.',
                    'Reserve 1 cup of pasta water before draining the spaghetti.',
                    'Remove pan from heat, add drained pasta to pancetta and toss well.',
                    'Add egg mixture and splash of pasta water, toss quickly to create a creamy sauce.',
                    'Serve immediately with extra cheese and black pepper on top.',
                ],
            ],
            [
                'title'       => 'Chicken Adobo',
                'description' => 'The quintessential Filipino dish — chicken braised in vinegar, soy sauce, garlic, and bay leaves. Savory, tangy, and absolutely delicious.',
                'category'    => 'Dinner',
                'prep_time'   => 15,
                'cook_time'   => 40,
                'image_url'   => 'https://images.unsplash.com/photo-1598103442097-8b74394b95c9?w=800',
                'ingredients' => [
                    ['quantity' => '1',   'unit' => 'kg',  'name' => 'Chicken pieces'],
                    ['quantity' => '1/2', 'unit' => 'cup', 'name' => 'Soy sauce'],
                    ['quantity' => '1/2', 'unit' => 'cup', 'name' => 'White vinegar'],
                    ['quantity' => '1',   'unit' => 'head','name' => 'Garlic, crushed'],
                    ['quantity' => '3',   'unit' => '',    'name' => 'Bay leaves'],
                    ['quantity' => '1',   'unit' => 'tsp', 'name' => 'Black peppercorns'],
                    ['quantity' => '1',   'unit' => 'tbsp','name' => 'Cooking oil'],
                ],
                'steps' => [
                    'Combine chicken, soy sauce, vinegar, garlic, bay leaves, and peppercorns in a pot.',
                    'Marinate for at least 30 minutes or overnight in the fridge.',
                    'Heat oil in a pan and brown the chicken pieces on all sides.',
                    'Pour in the marinade and bring to a boil.',
                    'Lower heat and simmer for 30 minutes until chicken is tender.',
                    'Increase heat to reduce the sauce to your preferred consistency.',
                    'Serve over steamed white rice.',
                ],
            ],
            [
                'title'       => 'Avocado Toast with Poached Egg',
                'description' => 'A healthy and trendy breakfast that is creamy, crunchy, and packed with nutrients. Ready in under 15 minutes!',
                'category'    => 'Breakfast',
                'prep_time'   => 5,
                'cook_time'   => 10,
                'image_url'   => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=800',
                'ingredients' => [
                    ['quantity' => '2',   'unit' => '',    'name' => 'Slices of sourdough bread'],
                    ['quantity' => '1',   'unit' => '',    'name' => 'Ripe avocado'],
                    ['quantity' => '2',   'unit' => '',    'name' => 'Eggs'],
                    ['quantity' => '1',   'unit' => 'tbsp','name' => 'Lemon juice'],
                    ['quantity' => '1',   'unit' => 'tsp', 'name' => 'Red pepper flakes'],
                    ['quantity' => '',    'unit' => '',    'name' => 'Salt and pepper to taste'],
                ],
                'steps' => [
                    'Toast the sourdough bread until golden and crispy.',
                    'Mash avocado with lemon juice, salt, and pepper in a bowl.',
                    'Bring a pot of water to a gentle simmer and add a splash of vinegar.',
                    'Crack eggs into the simmering water and poach for 3 minutes.',
                    'Spread avocado mash generously over the toast.',
                    'Top each slice with a poached egg.',
                    'Sprinkle with red pepper flakes and serve immediately.',
                ],
            ],
            [
                'title'       => 'Chocolate Lava Cake',
                'description' => 'Decadent individual chocolate cakes with a warm, gooey molten center. The ultimate dessert for chocolate lovers.',
                'category'    => 'Desserts',
                'prep_time'   => 15,
                'cook_time'   => 12,
                'image_url'   => 'https://images.unsplash.com/photo-1617305855058-336d24456869?w=800',
                'ingredients' => [
                    ['quantity' => '200', 'unit' => 'g',   'name' => 'Dark chocolate'],
                    ['quantity' => '100', 'unit' => 'g',   'name' => 'Butter'],
                    ['quantity' => '3',   'unit' => '',    'name' => 'Eggs'],
                    ['quantity' => '3',   'unit' => '',    'name' => 'Egg yolks'],
                    ['quantity' => '80',  'unit' => 'g',   'name' => 'Sugar'],
                    ['quantity' => '40',  'unit' => 'g',   'name' => 'All-purpose flour'],
                    ['quantity' => '1',   'unit' => 'tsp', 'name' => 'Vanilla extract'],
                ],
                'steps' => [
                    'Preheat oven to 220°C (425°F) and butter 4 ramekins.',
                    'Melt chocolate and butter together in a double boiler until smooth.',
                    'Whisk eggs, yolks, and sugar together until pale and thick.',
                    'Fold the chocolate mixture into the egg mixture.',
                    'Sift in flour and fold gently until just combined.',
                    'Pour batter into prepared ramekins and refrigerate for 30 minutes.',
                    'Bake for 10-12 minutes until edges are set but center jiggles.',
                    'Let rest for 1 minute, then invert onto plates and serve immediately.',
                ],
            ],
            [
                'title'       => 'Mango Smoothie',
                'description' => 'A refreshing and tropical smoothie bursting with sweet mango flavor. Perfect for hot days or a quick healthy breakfast.',
                'category'    => 'Drinks',
                'prep_time'   => 5,
                'cook_time'   => 0,
                'image_url'   => 'https://images.unsplash.com/photo-1623065422902-30a2d299bbe4?w=800',
                'ingredients' => [
                    ['quantity' => '2',   'unit' => '',    'name' => 'Ripe mangoes, peeled and diced'],
                    ['quantity' => '1',   'unit' => 'cup', 'name' => 'Plain yogurt'],
                    ['quantity' => '1/2', 'unit' => 'cup', 'name' => 'Milk'],
                    ['quantity' => '2',   'unit' => 'tbsp','name' => 'Honey'],
                    ['quantity' => '1',   'unit' => 'cup', 'name' => 'Ice cubes'],
                ],
                'steps' => [
                    'Add mango chunks to a blender.',
                    'Pour in yogurt, milk, and honey.',
                    'Add ice cubes on top.',
                    'Blend on high for 60 seconds until smooth and creamy.',
                    'Taste and adjust sweetness with more honey if needed.',
                    'Pour into glasses and serve immediately.',
                ],
            ],
            [
                'title'       => 'Caesar Salad',
                'description' => 'A classic Caesar salad with crispy romaine lettuce, homemade croutons, and a tangy Caesar dressing. Simple, fresh, and delicious.',
                'category'    => 'Lunch',
                'prep_time'   => 15,
                'cook_time'   => 10,
                'image_url'   => 'https://images.unsplash.com/photo-1546793665-c74683f339c1?w=800',
                'ingredients' => [
                    ['quantity' => '1',   'unit' => '',    'name' => 'Large romaine lettuce, chopped'],
                    ['quantity' => '100', 'unit' => 'g',   'name' => 'Parmesan cheese, shaved'],
                    ['quantity' => '2',   'unit' => 'cups','name' => 'Croutons'],
                    ['quantity' => '3',   'unit' => 'tbsp','name' => 'Caesar dressing'],
                    ['quantity' => '1',   'unit' => 'tsp', 'name' => 'Black pepper'],
                    ['quantity' => '1',   'unit' => '',    'name' => 'Lemon, juiced'],
                ],
                'steps' => [
                    'Wash and dry the romaine lettuce, then chop into bite-sized pieces.',
                    'Make croutons by toasting cubed bread with olive oil and garlic in a pan.',
                    'In a large bowl, toss lettuce with Caesar dressing until well coated.',
                    'Add croutons and half the Parmesan cheese and toss again.',
                    'Transfer to serving plates and top with remaining Parmesan.',
                    'Finish with black pepper and a squeeze of lemon juice.',
                ],
            ],
        ];

        foreach ($recipes as $data) {
            $category = Category::where('name', $data['category'])->first();

            // Download and store image
            $imagePath = null;
            try {
                $imageContents = file_get_contents($data['image_url']);
                if ($imageContents) {
                    $filename = 'recipe-images/' . uniqid() . '.jpg';
                    Storage::disk('public')->put($filename, $imageContents);
                    $imagePath = $filename;
                }
            } catch (\Exception $e) {
                // Skip image if download fails
            }

            $recipe = Recipe::create([
                'user_id'     => $admin->id,
                'category_id' => $category?->id,
                'title'       => $data['title'],
                'description' => $data['description'],
                'prep_time'   => $data['prep_time'],
                'cook_time'   => $data['cook_time'],
                'image'       => $imagePath,
            ]);

            foreach ($data['ingredients'] as $i => $ing) {
                $recipe->ingredients()->create([
                    'name'        => $ing['name'],
                    'quantity'    => $ing['quantity'],
                    'unit'        => $ing['unit'],
                    'order_index' => $i,
                ]);
            }

            foreach ($data['steps'] as $i => $step) {
                $recipe->steps()->create([
                    'step_number' => $i + 1,
                    'body'        => $step,
                ]);
            }
        }
    }
}