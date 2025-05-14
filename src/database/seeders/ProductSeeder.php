<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Filter;
use App\Models\FilterValue;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductTranslation;
use App\Models\ProductVariant;
use App\Models\VariantFilterValue;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $smartphones = Category::where('slug', 'smartphones')->first();
        $laptops = Category::where('slug', 'laptops')->first();

        // Get filters
        $colorFilter = Filter::where('type', 'color')->first();
        $brandFilter = Filter::where('type', 'brand')->first();
        $storageFilter = Filter::where('type', 'storage')->first();

        // Get filter values
        $colors = [
            'black' => FilterValue::where('value', 'black')->first(),
            'white' => FilterValue::where('value', 'white')->first(),
        ];
        $brands = [
            'apple' => FilterValue::where('value', 'apple')->first(),
            'samsung' => FilterValue::where('value', 'samsung')->first(),
        ];
        $storages = [
            '128gb' => FilterValue::where('value', '128gb')->first(),
            '256gb' => FilterValue::where('value', '256gb')->first(),
        ];

        // Create iPhone product
        $iphone = Product::firstOrCreate(
            ['slug' => 'iphone-14-pro'],
            [
                'category_id' => $smartphones->id,
                'sku' => 'IP14P',
                'price' => 999.99,
                'sale_price' => 899.99,
                'stock' => 100,
                'is_active' => true,
                'is_featured' => true,
            ]
        );

        // Add iPhone translations
        $iphoneTranslations = [
            'en' => [
                'name' => 'iPhone 14 Pro',
                'description' => 'The latest iPhone with advanced camera system and A16 Bionic chip.',
                'meta_title' => 'iPhone 14 Pro - Latest Apple Smartphone',
                'meta_description' => 'Experience the power of iPhone 14 Pro with its advanced camera system and A16 Bionic chip.',
            ],
            'fr' => [
                'name' => 'iPhone 14 Pro',
                'description' => 'Le dernier iPhone avec un système de caméra avancé et la puce A16 Bionic.',
                'meta_title' => 'iPhone 14 Pro - Dernier Smartphone Apple',
                'meta_description' => 'Découvrez la puissance de l\'iPhone 14 Pro avec son système de caméra avancé et sa puce A16 Bionic.',
            ],
        ];

        foreach ($iphoneTranslations as $locale => $data) {
            ProductTranslation::firstOrCreate(
                [
                    'product_id' => $iphone->id,
                    'locale' => $locale,
                ],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'meta_title' => $data['meta_title'],
                    'meta_description' => $data['meta_description'],
                ]
            );
        }

        // Add iPhone images
        ProductImage::firstOrCreate(
            [
                'product_id' => $iphone->id,
                'image_path' => 'products/iphone-14-pro-1.jpg',
            ],
            [
                'is_primary' => true,
            ]
        );

        ProductImage::firstOrCreate(
            [
                'product_id' => $iphone->id,
                'image_path' => 'products/iphone-14-pro-2.jpg',
            ],
            [
                'is_primary' => true,
            ]
        );

        // Create iPhone variants
        foreach ($colors as $colorKey => $colorValue) {
            foreach ($storages as $storageKey => $storageValue) {
                $variant = ProductVariant::firstOrCreate(
                    [
                        'product_id' => $iphone->id,
                        'sku' => "IP14P-{$colorKey}-{$storageKey}",
                    ],
                    [
                        'price' => 999.99,
                        'stock' => 25,
                    ]
                );

                // Add variant filter values
                VariantFilterValue::firstOrCreate(
                    [
                        'variant_id' => $variant->id,
                        'filter_value_id' => $colorValue->id,
                    ]
                );

                VariantFilterValue::firstOrCreate(
                    [
                        'variant_id' => $variant->id,
                        'filter_value_id' => $brands['apple']->id,
                    ]
                );

                VariantFilterValue::firstOrCreate(
                    [
                        'variant_id' => $variant->id,
                        'filter_value_id' => $storageValue->id,
                    ]
                );
            }
        }

        // Create Samsung Galaxy product
        $galaxy = Product::firstOrCreate(
            ['slug' => 'samsung-galaxy-s23'],
            [
                'category_id' => $smartphones->id,
                'sku' => 'SGS23',
                'price' => 899.99,
                'sale_price' => 799.99,
                'stock' => 100,
                'is_active' => true,
                'is_featured' => true,
            ]
        );

        // Add Galaxy translations
        $galaxyTranslations = [
            'en' => [
                'name' => 'Samsung Galaxy S23',
                'description' => 'The latest Samsung flagship with powerful camera and Snapdragon processor.',
                'meta_title' => 'Samsung Galaxy S23 - Latest Samsung Smartphone',
                'meta_description' => 'Experience the power of Samsung Galaxy S23 with its advanced camera system and Snapdragon processor.',
            ],
            'fr' => [
                'name' => 'Samsung Galaxy S23',
                'description' => 'Le dernier fleuron Samsung avec un appareil photo puissant et un processeur Snapdragon.',
                'meta_title' => 'Samsung Galaxy S23 - Dernier Smartphone Samsung',
                'meta_description' => 'Découvrez la puissance du Samsung Galaxy S23 avec son système de caméra avancé et son processeur Snapdragon.',
            ],
        ];

        foreach ($galaxyTranslations as $locale => $data) {
            ProductTranslation::firstOrCreate(
                [
                    'product_id' => $galaxy->id,
                    'locale' => $locale,
                ],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'meta_title' => $data['meta_title'],
                    'meta_description' => $data['meta_description'],
                ]
            );
        }

        // Add Galaxy images
        ProductImage::firstOrCreate(
            [
                'product_id' => $galaxy->id,
                'image_path' => 'products/galaxy-s23-1.jpg',
            ],
            [
                'is_primary' => true,
            ]
        );

        ProductImage::firstOrCreate(
            [
                'product_id' => $galaxy->id,
                'image_path' => 'products/galaxy-s23-2.jpg',
            ],
            [
                'is_primary' => true,
            ]
        );

        // Create Galaxy variants
        foreach ($colors as $colorKey => $colorValue) {
            foreach ($storages as $storageKey => $storageValue) {
                $variant = ProductVariant::firstOrCreate(
                    [
                        'product_id' => $galaxy->id,
                        'sku' => "SGS23-{$colorKey}-{$storageKey}",
                    ],
                    [
                        'price' => 899.99,
                        'stock' => 25,
                    ]
                );

                // Add variant filter values
                VariantFilterValue::firstOrCreate(
                    [
                        'variant_id' => $variant->id,
                        'filter_value_id' => $colorValue->id,
                    ]
                );

                VariantFilterValue::firstOrCreate(
                    [
                        'variant_id' => $variant->id,
                        'filter_value_id' => $brands['samsung']->id,
                    ]
                );

                VariantFilterValue::firstOrCreate(
                    [
                        'variant_id' => $variant->id,
                        'filter_value_id' => $storageValue->id,
                    ]
                );
            }
        }
    }
}
