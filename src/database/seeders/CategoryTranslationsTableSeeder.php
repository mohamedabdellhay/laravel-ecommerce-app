<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Database\Seeder;

class CategoryTranslationsTableSeeder extends Seeder
{
    public function run()
    {
        $translations = [
            1 => ['en' => 'Electronics', 'ar' => 'إلكترونيات'],
            2 => ['en' => 'Clothing', 'ar' => 'ملابس'],
            3 => ['en' => 'Books', 'ar' => 'كتب'],
            4 => ['en' => 'Smartphones', 'ar' => 'هواتف ذكية'],
        ];

        foreach ($translations as $categoryId => $names) {
            foreach (['en', 'ar'] as $locale) {
                CategoryTranslation::create([
                    'category_id' => $categoryId,
                    'locale' => $locale,
                    'name' => $names[$locale],
                ]);
            }
        }
    }
}
