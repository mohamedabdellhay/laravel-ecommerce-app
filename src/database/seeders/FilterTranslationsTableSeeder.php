<?php

namespace Database\Seeders;

use App\Models\FilterTranslation;
use Illuminate\Database\Seeder;

class FilterTranslationsTableSeeder extends Seeder
{
    public function run()
    {
        $translations = [
            1 => ['en' => 'Color', 'ar' => 'اللون'],
            2 => ['en' => 'Size', 'ar' => 'الحجم'],
        ];

        foreach ($translations as $filterId => $names) {
            foreach (['en', 'ar'] as $locale) {
                FilterTranslation::create([
                    'filter_id' => $filterId,
                    'locale' => $locale,
                    'name' => $names[$locale],
                ]);
            }
        }
    }
}
