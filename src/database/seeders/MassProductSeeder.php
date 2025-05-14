<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MassProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * This seeder creates 10,000 products with translations and images
     * using batch inserts for efficiency.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all category IDs for random assignment
        $categoryIds = Category::pluck('id')->toArray();
        if (empty($categoryIds)) {
            $this->command->error('No categories found. Please run the CategorySeeder first.');
            return;
        }

        // Define batch size to avoid memory issues
        $batchSize = 500;
        $totalProducts = 10000;

        // Prepare placeholder images
        $imagePaths = [
            'products/placeholder-1.jpg',
            'products/placeholder-2.jpg',
            'products/placeholder-3.jpg',
            'products/placeholder-4.jpg',
            'products/placeholder-5.jpg',
        ];

        // Supported locales
        $locales = ['en', 'fr'];

        $this->command->info('Starting to seed 10,000 products...');
        $this->command->info('This might take a while, please be patient.');

        // Get the starting ID (current max ID + 1)
        $startId = (int) DB::table('products')->max('id') + 1;
        $this->command->info("Starting from product ID: {$startId}");

        // Create products in batches
        for ($i = 0; $i < $totalProducts; $i += $batchSize) {
            $this->command->info("Seeding products " . ($i + 1) . " to " . min($i + $batchSize, $totalProducts));

            $productsData = [];
            $translationsData = [];
            $imagesData = [];
            $variantsData = [];

            $currentBatchSize = min($batchSize, $totalProducts - $i);

            for ($j = 0; $j < $currentBatchSize; $j++) {
                $productId = $startId + $i + $j; // Use the correct starting ID
                $productBase = $faker->unique()->words(3, true);
                $slug = Str::slug($productBase . '-' . $productId);
                $price = $faker->randomFloat(2, 10, 1000);
                $categoryId = $faker->randomElement($categoryIds);

                // Product data
                $productsData[] = [
                    'id' => $productId, // Explicitly set the ID
                    'slug' => $slug,
                    'sku' => 'SKU-' . $productId,
                    'price' => $price,
                    'sale_price' => $faker->boolean(30) ? $price * 0.9 : null,
                    'stock' => $faker->numberBetween(0, 100),
                    'category_id' => $categoryId,
                    'is_active' => $faker->boolean(90),
                    'is_featured' => $faker->boolean(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Create translations for each locale
                foreach ($locales as $locale) {
                    $productName = $locale === 'en' ?
                        ucwords($productBase) . ' ' . $productId :
                        'Produit ' . $productId . ' ' . $faker->words(2, true);

                    $translationsData[] = [
                        'product_id' => $productId,
                        'locale' => $locale,
                        'name' => $productName,
                        'description' => $faker->paragraph(3),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Create 1-3 images per product
                $imageCount = $faker->numberBetween(1, 3);
                for ($k = 0; $k < $imageCount; $k++) {
                    $imagesData[] = [
                        'product_id' => $productId,
                        'image_path' => $faker->randomElement($imagePaths),
                        'is_primary' => $k === 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Create 1-3 variants per product
                $variantCount = $faker->numberBetween(1, 3);
                for ($v = 0; $v < $variantCount; $v++) {
                    $variantsData[] = [
                        'product_id' => $productId,
                        'sku' => 'VARIANT-' . $productId . '-' . ($v + 1),
                        'price' => $price + $faker->randomFloat(2, 0, 100), // Slightly different price
                        'stock' => $faker->numberBetween(0, 50),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Batch insert products
            DB::table('products')->insert($productsData);

            // Batch insert translations
            DB::table('product_translations')->insert($translationsData);

            // Batch insert images
            DB::table('product_images')->insert($imagesData);

            // Batch insert variants
            DB::table('product_variants')->insert($variantsData);

            // Clear memory
            unset($productsData, $translationsData, $imagesData, $variantsData);

            // Some feedback
            $this->command->info("Completed batch ending at product #" . ($i + $currentBatchSize));
        }

        $this->command->info('Successfully seeded 10,000 products with translations and images!');
    }
}
