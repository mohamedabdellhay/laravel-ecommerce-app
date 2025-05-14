<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        $orders = [];

        // Create 1000 orders
        $statuses = ['pending', 'shipped', 'delivered', 'canceled'];

        for ($i = 0; $i < 1000; $i++) {
            $orders[] = [
                'user_id' => rand(2, 10), // Assuming user IDs 2-10 are customers
                'total' => round(rand(999, 100000) / 100, 2), // Random total between $9.99 and $1000.00
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now()->subDays(rand(1, 365)), // Random date within the last year
            ];
        }

        // Add our original two specific orders
        $orders[] = [
            'user_id' => 2, // Customer
            'total' => 1049.98,
            'status' => 'pending',
            'created_at' => now()->subDays(5), // Added created_at
        ];

        $orders[] = [
            'user_id' => 3, // Customer
            'total' => 29.99,
            'status' => 'shipped',
            'created_at' => now()->subDays(10), // Added created_at
        ];

        foreach ($orders as $order) {
            Order::updateOrCreate(
                ['user_id' => $order['user_id'], 'created_at' => $order['created_at']],
                ['total' => $order['total'], 'status' => $order['status'], 'updated_at' => now()]
            );
        }
    }
}
