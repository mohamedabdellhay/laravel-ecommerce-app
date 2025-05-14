<?php

namespace Database\Seeders;

use App\Models\ProductTranslation;
use Illuminate\Database\Seeder;

class ProductTranslationsTableSeeder extends Seeder
{
    public function run()
    {
        $translations = [
            1 => [
                'en' => ['name' => 'Smartphone X', 'description' => 'Latest smartphone model'],
                'ar' => ['name' => 'هاتف ذكي X', 'description' => 'أحدث طراز هاتف ذكي'],
            ],
            2 => [
                'en' => ['name' => 'T-Shirt', 'description' => 'Comfortable cotton t-shirt'],
                'ar' => ['name' => 'تي شيرت', 'description' => 'تي شيرت قطني مريح'],
            ],
            3 => [
                'en' => ['name' => 'Novel', 'description' => 'Bestselling fiction novel'],
                'ar' => ['name' => 'رواية', 'description' => 'رواية خيالية الأكثر مبيعًا'],
            ],
        ];

        foreach ($translations as $productId => $data) {
            foreach (['en', 'ar'] as $locale) {
                ProductTranslation::create([
                    'product_id' => $productId,
                    'locale' => $locale,
                    'name' => $data[$locale]['name'],
                    'description' => $data[$locale]['description'],
                ]);
            }
        }
    }
}
