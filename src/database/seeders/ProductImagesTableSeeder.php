<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImagesTableSeeder extends Seeder
{
    public function run()
    {
        $images = [
            ['product_id' => 1, 'image_path' => 'smartphone_x.jpg', 'is_primary' => true],
            ['product_id' => 2, 'image_path' => 'tshirt.jpg', 'is_primary' => true],
            ['product_id' => 3, 'image_path' => 'novel.jpg', 'is_primary' => true],
        ];

        foreach ($images as $image) {
            ProductImage::create($image);
        }
    }
}
