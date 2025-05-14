<?php

namespace Database\Seeders;

use App\Models\VariantFilterValue;
use Illuminate\Database\Seeder;

class VariantFilterValuesTableSeeder extends Seeder
{
    public function run()
    {
        $relations = [
            ['variant_id' => 1, 'filter_value_id' => 1], // Smartphone X - Red
            ['variant_id' => 2, 'filter_value_id' => 3], // T-Shirt - Large
            ['variant_id' => 3, 'filter_value_id' => 3], // Novel - Large (e.g., Hardcover)
        ];

        foreach ($relations as $relation) {
            VariantFilterValue::create($relation);
        }
    }
}
