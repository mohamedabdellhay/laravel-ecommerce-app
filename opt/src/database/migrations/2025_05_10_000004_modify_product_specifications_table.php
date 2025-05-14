<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First backup existing data
        $productSpecs = DB::table('product_specifications')->get();

        // Drop the old pivot table
        Schema::dropIfExists('product_specifications');

        // Create a new pivot table with references to specification values
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('specification_id')->constrained()->cascadeOnDelete();
            $table->foreignId('specification_value_id')->nullable()
                ->constrained('specification_values')->nullOnDelete();
            $table->string('custom_value')->nullable(); // For custom text values not in the predefined list
            $table->timestamps();

            // A product can only have one value per specification
            $table->unique(['product_id', 'specification_id', 'specification_value_id'], 'product_spec_value_unique');
        });

        // Note: Old data will need to be manually migrated or handled via a data migration script
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_specifications');

        // Recreate the original table structure
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('specification_id')->constrained()->cascadeOnDelete();
            $table->string('value')->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'specification_id']);
        });
    }
};
