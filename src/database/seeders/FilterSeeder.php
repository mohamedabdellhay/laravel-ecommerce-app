<?php

namespace Database\Seeders;

use App\Models\Filter;
use App\Models\FilterTranslation;
use App\Models\FilterValue;
use App\Models\FilterValueTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create filters for electronics
        $color = Filter::create([
            'type' => 'color',
            'input_type' => 'select',
            'is_required' => false,
            'display_order' => 1,
        ]);

        $size = Filter::create([
            'type' => 'size',
            'input_type' => 'select',
            'is_required' => false,
            'display_order' => 2,
        ]);

        $brand = Filter::create([
            'type' => 'brand',
            'input_type' => 'select',
            'is_required' => true,
            'display_order' => 3,
        ]);

        $storage = Filter::create([
            'type' => 'storage',
            'input_type' => 'select',
            'is_required' => true,
            'display_order' => 4,
        ]);

        // Add translations for filters
        $filters = [
            'color' => [
                'en' => ['name' => 'Color', 'description' => 'Product color'],
                'fr' => ['name' => 'Couleur', 'description' => 'Couleur du produit'],
            ],
            'size' => [
                'en' => ['name' => 'Size', 'description' => 'Product size'],
                'fr' => ['name' => 'Taille', 'description' => 'Taille du produit'],
            ],
            'brand' => [
                'en' => ['name' => 'Brand', 'description' => 'Product brand'],
                'fr' => ['name' => 'Marque', 'description' => 'Marque du produit'],
            ],
            'storage' => [
                'en' => ['name' => 'Storage', 'description' => 'Storage capacity'],
                'fr' => ['name' => 'Stockage', 'description' => 'Capacité de stockage'],
            ],
        ];

        foreach ($filters as $type => $translations) {
            $filter = Filter::where('type', $type)->first();
            foreach ($translations as $locale => $data) {
                FilterTranslation::create([
                    'filter_id' => $filter->id,
                    'locale' => $locale,
                    'name' => $data['name'],
                    'description' => $data['description'],
                ]);
            }
        }

        // Add filter values
        $filterValues = [
            'color' => [
                'red' => ['en' => 'Red', 'fr' => 'Rouge'],
                'blue' => ['en' => 'Blue', 'fr' => 'Bleu'],
                'black' => ['en' => 'Black', 'fr' => 'Noir'],
                'white' => ['en' => 'White', 'fr' => 'Blanc'],
            ],
            'size' => [
                's' => ['en' => 'Small', 'fr' => 'Petit'],
                'm' => ['en' => 'Medium', 'fr' => 'Moyen'],
                'l' => ['en' => 'Large', 'fr' => 'Grand'],
                'xl' => ['en' => 'Extra Large', 'fr' => 'Très Grand'],
            ],
            'brand' => [
                'apple' => ['en' => 'Apple', 'fr' => 'Apple'],
                'samsung' => ['en' => 'Samsung', 'fr' => 'Samsung'],
                'sony' => ['en' => 'Sony', 'fr' => 'Sony'],
                'lg' => ['en' => 'LG', 'fr' => 'LG'],
            ],
            'storage' => [
                '64gb' => ['en' => '64 GB', 'fr' => '64 Go'],
                '128gb' => ['en' => '128 GB', 'fr' => '128 Go'],
                '256gb' => ['en' => '256 GB', 'fr' => '256 Go'],
                '512gb' => ['en' => '512 GB', 'fr' => '512 Go'],
            ],
        ];

        foreach ($filterValues as $type => $values) {
            $filter = Filter::where('type', $type)->first();
            foreach ($values as $value => $translations) {
                $filterValue = FilterValue::create([
                    'filter_id' => $filter->id,
                    'value' => $value,
                    'display_order' => array_search($value, array_keys($values)) + 1,
                ]);

                foreach ($translations as $locale => $name) {
                    FilterValueTranslation::create([
                        'filter_value_id' => $filterValue->id,
                        'locale' => $locale,
                        'name' => $name,
                        'description' => '',
                    ]);
                }
            }
        }
    }
}
