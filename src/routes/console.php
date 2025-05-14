<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('seed:mass-products', function () {
    $this->info('Generating placeholder images...');
    Artisan::call('products:generate-placeholders', [
        'count' => 5
    ]);

    $this->info('Starting to seed 10,000 products...');
    Artisan::call('db:seed', [
        '--class' => 'Database\\Seeders\\MassProductSeeder'
    ]);
    $this->info('Finished seeding products!');
})->purpose('Seed 10,000 products for testing');
