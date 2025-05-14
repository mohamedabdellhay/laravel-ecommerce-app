<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class OrderItemsTableSeeder extends Seeder
{
    public function run()
    {
        // Check if we have any variants in the database
        $variantCount = ProductVariant::count();

        if ($variantCount === 0) {
            // If no variants found, create a few variants for the first products
            $this->createVariantsForFirstProducts();
            // Get the newly created variants
            $variants = ProductVariant::take(3)->get();
        } else {
            // Get the first 3 variants from the database
            $variants = ProductVariant::take(3)->get();
        }

        // Create order items with the existing variants
        $orderItems = [
            [
                'order_id' => 1,
                'variant_id' => $variants[0]->id,
                'quantity' => 1,
                'price' => 999.99,
            ],
            [
                'order_id' => 1,
                'variant_id' => $variants[1]->id ?? $variants[0]->id,
                'quantity' => 1,
                'price' => 49.99,
            ],
            [
                'order_id' => 2,
                'variant_id' => $variants[2]->id ?? $variants[0]->id,
                'quantity' => 1,
                'price' => 29.99,
            ],
        ];

        foreach ($orderItems as $item) {
            OrderItem::create($item);
        }
    }

    private function createVariantsForFirstProducts()
    {
        // Get the first 3 products
        $productIds = \App\Models\Product::take(3)->pluck('id');

        foreach ($productIds as $index => $productId) {
            ProductVariant::create([
                'product_id' => $productId,
                'sku' => 'VARIANT-' . $productId,
                'price' => ($index + 1) * 100 - 0.01, // 99.99, 199.99, 299.99
                'stock' => 10,
            ]);
        }
    }
}
