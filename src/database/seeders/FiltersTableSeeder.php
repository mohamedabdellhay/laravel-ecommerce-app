<?php

namespace Database\Seeders;

use App\Models\Filter;
use Illuminate\Database\Seeder;

class FiltersTableSeeder extends Seeder
{
    public function run()
    {
        Filter::create([]); // Color
        Filter::create([]); // Size
    }
}
