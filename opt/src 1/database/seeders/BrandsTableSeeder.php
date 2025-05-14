<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'description' => 'Apple Inc. is an American multinational technology company.',
                'logo' => 'brands/apple.png',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Samsung',
                'description' => 'Samsung Electronics Co., Ltd. is a South Korean multinational electronics company.',
                'logo' => 'brands/samsung.png',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Nike',
                'description' => 'Nike, Inc. is an American multinational corporation that designs, develops, manufactures, and markets footwear, apparel, equipment, accessories, and services.',
                'logo' => 'brands/nike.png',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Adidas',
                'description' => 'Adidas AG is a German multinational corporation that designs and manufactures shoes, clothing and accessories.',
                'logo' => 'brands/adidas.png',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Sony',
                'description' => 'Sony Corporation is a Japanese multinational conglomerate corporation headquartered in Kōnan, Minato, Tokyo.',
                'logo' => 'brands/sony.png',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Dell',
                'description' => 'Dell Technologies, Inc. is an American multinational technology company.',
                'logo' => 'brands/dell.png',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'HP',
                'description' => 'HP Inc. is an American multinational information technology company.',
                'logo' => 'brands/hp.png',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'LG',
                'description' => 'LG Corporation is a South Korean multinational conglomerate corporation.',
                'logo' => 'brands/lg.png',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Asus',
                'description' => 'ASUSTeK Computer Inc. is a Taiwanese multinational computer and phone hardware and electronics company.',
                'logo' => 'brands/asus.png',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Logitech',
                'description' => 'Logitech International S.A. is a Swiss manufacturer of computer peripherals and software.',
                'logo' => 'brands/logitech.png',
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name']),
                'description' => $brand['description'],
                'logo' => $brand['logo'],
                'is_featured' => $brand['is_featured'],
                'is_active' => $brand['is_active'],
            ]);
        }
    }
}
