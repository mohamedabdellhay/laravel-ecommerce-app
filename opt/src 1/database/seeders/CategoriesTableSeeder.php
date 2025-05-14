<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and accessories',
                'image' => 'categories/electronics.jpg',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Clothing',
                'description' => 'Men\'s and women\'s clothing',
                'image' => 'categories/clothing.jpg',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home décor, furniture, and garden supplies',
                'image' => 'categories/home-garden.jpg',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sporting goods and outdoor equipment',
                'image' => 'categories/sports-outdoors.jpg',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Books',
                'description' => 'Physical books and e-books',
                'image' => 'categories/books.jpg',
                'is_active' => true,
                'order' => 5,
            ]
        ];

        // Create parent categories
        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'image' => $category['image'],
                'is_active' => $category['is_active'],
                'order' => $category['order'],
            ]);
        }

        // Create subcategories for Electronics
        $electronicsId = Category::where('name', 'Electronics')->first()->id;
        $electronicsSubcategories = [
            [
                'name' => 'Smartphones',
                'description' => 'Mobile phones and accessories',
                'image' => 'categories/smartphones.jpg',
                'parent_id' => $electronicsId,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Laptops',
                'description' => 'Notebook computers and accessories',
                'image' => 'categories/laptops.jpg',
                'parent_id' => $electronicsId,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Audio',
                'description' => 'Headphones, speakers, and audio equipment',
                'image' => 'categories/audio.jpg',
                'parent_id' => $electronicsId,
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($electronicsSubcategories as $subcategory) {
            Category::create([
                'name' => $subcategory['name'],
                'slug' => Str::slug($subcategory['name']),
                'description' => $subcategory['description'],
                'image' => $subcategory['image'],
                'parent_id' => $subcategory['parent_id'],
                'is_active' => $subcategory['is_active'],
                'order' => $subcategory['order'],
            ]);
        }

        // Create subcategories for Clothing
        $clothingId = Category::where('name', 'Clothing')->first()->id;
        $clothingSubcategories = [
            [
                'name' => 'Men\'s',
                'description' => 'Men\'s clothing and accessories',
                'image' => 'categories/mens.jpg',
                'parent_id' => $clothingId,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Women\'s',
                'description' => 'Women\'s clothing and accessories',
                'image' => 'categories/womens.jpg',
                'parent_id' => $clothingId,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Kids',
                'description' => 'Children\'s clothing and accessories',
                'image' => 'categories/kids.jpg',
                'parent_id' => $clothingId,
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($clothingSubcategories as $subcategory) {
            Category::create([
                'name' => $subcategory['name'],
                'slug' => Str::slug($subcategory['name']),
                'description' => $subcategory['description'],
                'image' => $subcategory['image'],
                'parent_id' => $subcategory['parent_id'],
                'is_active' => $subcategory['is_active'],
                'order' => $subcategory['order'],
            ]);
        }
    }
}
