<?php

namespace Database\Seeders;

use App\Models\FilterValue;
use Illuminate\Database\Seeder;

class FilterValuesTableSeeder extends Seeder
{
    public function run()
    {
        // Color values
        FilterValue::create(['filter_id' => 1]); // Red
        FilterValue::create(['filter_id' => 1]); // Blue
        // Size values
        FilterValue::create(['filter_id' => 2]); // Large
        FilterValue::create(['filter_id' => 2]); // Medium
    }
}
