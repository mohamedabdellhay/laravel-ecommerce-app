<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get IDs for later use
        $smartphonesId = Category::where('name', 'Smartphones')->first()->id;
        $laptopsId = Category::where('name', 'Laptops')->first()->id;
        $audioId = Category::where('name', 'Audio')->first()->id;
        $mensId = Category::where('name', 'Men\'s')->first()->id;
        $womensId = Category::where('name', 'Women\'s')->first()->id;

        $appleId = Brand::where('name', 'Apple')->first()->id;
        $samsungId = Brand::where('name', 'Samsung')->first()->id;
        $sonyId = Brand::where('name', 'Sony')->first()->id;
        $dellId = Brand::where('name', 'Dell')->first()->id;
        $lgId = Brand::where('name', 'LG')->first()->id;
        $nikeId = Brand::where('name', 'Nike')->first()->id;
        $adidasId = Brand::where('name', 'Adidas')->first()->id;

        $products = [
            // Smartphones
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'The latest iPhone with advanced features and improved camera.',
                'short_description' => 'Latest iPhone model with advanced features',
                'price' => 999.99,
                'discount_price' => 949.99,
                'sku' => 'IP15PRO-1',
                'stock' => 50,
                'image' => 'products/iphone15-pro.jpg',
                'is_featured' => true,
                'status' => 'active',
                'category_id' => $smartphonesId,
                'brand_id' => $appleId,
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'The flagship Samsung smartphone with cutting-edge technology.',
                'short_description' => 'Samsung\'s flagship smartphone',
                'price' => 1199.99,
                'discount_price' => 1099.99,
                'sku' => 'SGS24U-1',
                'stock' => 35,
                'image' => 'products/galaxy-s24-ultra.jpg',
                'is_featured' => true,
                'status' => 'active',
                'category_id' => $smartphonesId,
                'brand_id' => $samsungId,
            ],

            // Laptops
            [
                'name' => 'MacBook Pro 16-inch',
                'description' => 'Powerful MacBook Pro with M3 chip for professional workflows.',
                'short_description' => 'Apple\'s professional laptop with M3 chip',
                'price' => 2499.99,
                'discount_price' => null,
                'sku' => 'MBP16-M3-1',
                'stock' => 20,
                'image' => 'products/macbook-pro-16.jpg',
                'is_featured' => true,
                'status' => 'active',
                'category_id' => $laptopsId,
                'brand_id' => $appleId,
            ],
            [
                'name' => 'Dell XPS 15',
                'description' => 'Premium Windows laptop with high-resolution display and powerful performance.',
                'short_description' => 'Premium Windows laptop',
                'price' => 1899.99,
                'discount_price' => 1799.99,
                'sku' => 'DXPS15-1',
                'stock' => 15,
                'image' => 'products/dell-xps-15.jpg',
                'is_featured' => false,
                'status' => 'active',
                'category_id' => $laptopsId,
                'brand_id' => $dellId,
            ],

            // Audio
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Industry-leading noise cancelling headphones with exceptional sound quality.',
                'short_description' => 'Premium noise cancelling headphones',
                'price' => 399.99,
                'discount_price' => 349.99,
                'sku' => 'SWXM5-1',
                'stock' => 40,
                'image' => 'products/sony-wh1000xm5.jpg',
                'is_featured' => true,
                'status' => 'active',
                'category_id' => $audioId,
                'brand_id' => $sonyId,
            ],
            [
                'name' => 'Apple AirPods Pro 2',
                'description' => 'Active noise cancellation and immersive sound in a compact design.',
                'short_description' => 'Apple\'s premium wireless earbuds',
                'price' => 249.99,
                'discount_price' => 229.99,
                'sku' => 'APP2-1',
                'stock' => 60,
                'image' => 'products/airpods-pro-2.jpg',
                'is_featured' => false,
                'status' => 'active',
                'category_id' => $audioId,
                'brand_id' => $appleId,
            ],

            // Men's Clothing
            [
                'name' => 'Nike Dri-FIT Running Shirt',
                'description' => 'Moisture-wicking shirt designed for running and training.',
                'short_description' => 'Performance running shirt',
                'price' => 49.99,
                'discount_price' => null,
                'sku' => 'NDFTRS-M-1',
                'stock' => 100,
                'image' => 'products/nike-drifit-shirt.jpg',
                'is_featured' => false,
                'status' => 'active',
                'category_id' => $mensId,
                'brand_id' => $nikeId,
            ],
            [
                'name' => 'Adidas Ultraboost Shoes',
                'description' => 'Energy-returning running shoes with responsive cushioning.',
                'short_description' => 'Premium running shoes',
                'price' => 189.99,
                'discount_price' => 159.99,
                'sku' => 'AUBS-10-1',
                'stock' => 25,
                'image' => 'products/adidas-ultraboost.jpg',
                'is_featured' => true,
                'status' => 'active',
                'category_id' => $mensId,
                'brand_id' => $adidasId,
            ],

            // Women's Clothing
            [
                'name' => 'Nike Yoga Leggings',
                'description' => 'Stretchy, comfortable leggings designed for yoga and everyday wear.',
                'short_description' => 'Comfortable yoga leggings',
                'price' => 79.99,
                'discount_price' => 69.99,
                'sku' => 'NYL-S-1',
                'stock' => 80,
                'image' => 'products/nike-yoga-leggings.jpg',
                'is_featured' => false,
                'status' => 'active',
                'category_id' => $womensId,
                'brand_id' => $nikeId,
            ],
            [
                'name' => 'Adidas Essentials Hoodie',
                'description' => 'Soft, warm hoodie perfect for workouts or casual wear.',
                'short_description' => 'Versatile hoodie for women',
                'price' => 65.99,
                'discount_price' => null,
                'sku' => 'AEH-M-1',
                'stock' => 45,
                'image' => 'products/adidas-hoodie-women.jpg',
                'is_featured' => false,
                'status' => 'active',
                'category_id' => $womensId,
                'brand_id' => $adidasId,
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'short_description' => $product['short_description'],
                'price' => $product['price'],
                'discount_price' => $product['discount_price'],
                'sku' => $product['sku'],
                'stock' => $product['stock'],
                'image' => $product['image'],
                'is_featured' => $product['is_featured'],
                'status' => $product['status'],
                'category_id' => $product['category_id'],
                'brand_id' => $product['brand_id'],
            ]);
        }
    }
}
