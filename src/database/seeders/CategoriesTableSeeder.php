<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['slug' => 'electronics'],
            ['slug' => 'clothing'],
            ['slug' => 'books'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Subcategory example
        Category::create([
            'slug' => 'smartphones',
            'parent_id' => 1, // Electronics
        ]);
    }
}
