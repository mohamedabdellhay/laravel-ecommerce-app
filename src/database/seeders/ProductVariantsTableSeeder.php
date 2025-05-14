<?php

namespace Database\Seeders;

use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantsTableSeeder extends Seeder
{
    public function run()
    {
        $variants = [
            [
                'product_id' => 1,
                'sku' => 'SMARTPHONE-X-RED',
                'price' => 999.99,
                'stock' => 20,
            ],
            [
                'product_id' => 2,
                'sku' => 'TSHIRT-LARGE',
                'price' => 49.99,
                'stock' => 50,
            ],
            [
                'product_id' => 3,
                'sku' => 'NOVEL-HARDCOVER',
                'price' => 29.99,
                'stock' => 15,
            ],
        ];

        foreach ($variants as $variant) {
            ProductVariant::create($variant);
        }
    }
}
