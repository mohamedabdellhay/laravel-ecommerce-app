<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateProductPlaceholders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:generate-placeholders {count=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate placeholder images for products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->argument('count');
        $this->info("Generating {$count} placeholder files...");

        // Make sure the directory exists
        Storage::disk('public')->makeDirectory('products', 0755, true);

        // Colors (just for reference in filename)
        $colors = [
            'blue',
            'red',
            'green',
            'yellow',
            'purple',
            'turquoise',
            'orange',
            'darkblue',
        ];

        for ($i = 1; $i <= $count; $i++) {
            $color = $colors[($i - 1) % count($colors)];
            $imagePath = "products/placeholder-{$i}.jpg";

            // Create a simple text file with product information
            $content = "Product Placeholder {$i}\nColor: {$color}\nGenerated on: " . date('Y-m-d H:i:s');

            // Store the file
            Storage::disk('public')->put($imagePath, $content);

            $this->info("Generated {$imagePath}");
        }

        $this->info("Placeholder files generated successfully!");
    }
}
