<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('specification_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specification_id')->constrained()->cascadeOnDelete();
            $table->string('value');
            $table->string('slug')->nullable();
            $table->string('color_code')->nullable(); // For color specs
            $table->timestamps();

            $table->unique(['specification_id', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specification_values');
    }
};
