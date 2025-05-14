<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main categories
        $electronics = Category::firstOrCreate(
            ['slug' => 'electronics'],
            ['slug' => 'electronics']
        );

        $clothing = Category::firstOrCreate(
            ['slug' => 'clothing'],
            ['slug' => 'clothing']
        );

        $home = Category::firstOrCreate(
            ['slug' => 'home'],
            ['slug' => 'home']
        );

        // Create subcategories for electronics
        $smartphones = Category::firstOrCreate(
            ['slug' => 'smartphones'],
            [
                'parent_id' => $electronics->id,
                'slug' => 'smartphones'
            ]
        );

        $laptops = Category::firstOrCreate(
            ['slug' => 'laptops'],
            [
                'parent_id' => $electronics->id,
                'slug' => 'laptops'
            ]
        );

        // Create subcategories for clothing
        $men = Category::firstOrCreate(
            ['slug' => 'men'],
            [
                'parent_id' => $clothing->id,
                'slug' => 'men'
            ]
        );

        $women = Category::firstOrCreate(
            ['slug' => 'women'],
            [
                'parent_id' => $clothing->id,
                'slug' => 'women'
            ]
        );

        // Add translations for all categories
        $categories = [
            'electronics' => [
                'en' => ['name' => 'Electronics', 'description' => 'Electronic devices and gadgets'],
                'fr' => ['name' => 'Électronique', 'description' => 'Appareils et gadgets électroniques'],
            ],
            'clothing' => [
                'en' => ['name' => 'Clothing', 'description' => 'Fashion and apparel'],
                'fr' => ['name' => 'Vêtements', 'description' => 'Mode et vêtements'],
            ],
            'home' => [
                'en' => ['name' => 'Home & Living', 'description' => 'Home decor and furniture'],
                'fr' => ['name' => 'Maison & Décoration', 'description' => 'Décoration et meubles'],
            ],
            'smartphones' => [
                'en' => ['name' => 'Smartphones', 'description' => 'Mobile phones and accessories'],
                'fr' => ['name' => 'Smartphones', 'description' => 'Téléphones mobiles et accessoires'],
            ],
            'laptops' => [
                'en' => ['name' => 'Laptops', 'description' => 'Notebooks and accessories'],
                'fr' => ['name' => 'Ordinateurs portables', 'description' => 'Ordinateurs portables et accessoires'],
            ],
            'men' => [
                'en' => ['name' => 'Men\'s Clothing', 'description' => 'Men\'s fashion and accessories'],
                'fr' => ['name' => 'Vêtements Homme', 'description' => 'Mode et accessoires pour hommes'],
            ],
            'women' => [
                'en' => ['name' => 'Women\'s Clothing', 'description' => 'Women\'s fashion and accessories'],
                'fr' => ['name' => 'Vêtements Femme', 'description' => 'Mode et accessoires pour femmes'],
            ],
        ];

        foreach ($categories as $slug => $translations) {
            $category = Category::where('slug', $slug)->first();
            if (!$category) {
                $this->command->error("Category with slug '{$slug}' not found!");
                continue;
            }

            foreach ($translations as $locale => $data) {
                CategoryTranslation::firstOrCreate(
                    [
                        'category_id' => $category->id,
                        'locale' => $locale,
                    ],
                    [
                        'name' => $data['name'],
                        'description' => $data['description'],
                    ]
                );
            }
        }
    }
}
