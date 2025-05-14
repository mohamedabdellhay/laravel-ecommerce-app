<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            CategorySeeder::class,
            FilterSeeder::class,
            // Choose one of the product seeders:
            // ProductSeeder::class, // Default seeder with a few products
            MassProductSeeder::class, // Seeder for 10,000 products
            OrdersTableSeeder::class,
            OrderItemsTableSeeder::class,
        ]);
    }
}
