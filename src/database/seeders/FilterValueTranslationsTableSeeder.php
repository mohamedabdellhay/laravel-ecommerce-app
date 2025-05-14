<?php

namespace Database\Seeders;

use App\Models\FilterValueTranslation;
use Illuminate\Database\Seeder;

class FilterValueTranslationsTableSeeder extends Seeder
{
    public function run()
    {
        $translations = [
            1 => ['en' => 'Red', 'ar' => 'أحمر'],
            2 => ['en' => 'Blue', 'ar' => 'أزرق'],
            3 => ['en' => 'Large', 'ar' => 'كبير'],
            4 => ['en' => 'Medium', 'ar' => 'متوسط'],
        ];

        foreach ($translations as $filterValueId => $values) {
            foreach (['en', 'ar'] as $locale) {
                FilterValueTranslation::create([
                    'filter_value_id' => $filterValueId,
                    'locale' => $locale,
                    'value' => $values[$locale],
                ]);
            }
        }
    }
}
