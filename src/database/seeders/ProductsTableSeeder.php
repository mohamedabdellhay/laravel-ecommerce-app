<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'price' => 999.99,
                'stock' => 50,
                'category_id' => 1, // Electronics
                'slug' => 'smartphone-x',
            ],
            [
                'price' => 49.99,
                'stock' => 100,
                'category_id' => 2, // Clothing
                'slug' => 't-shirt',
            ],
            [
                'price' => 29.99,
                'stock' => 30,
                'category_id' => 3, // Books
                'slug' => 'novel',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
