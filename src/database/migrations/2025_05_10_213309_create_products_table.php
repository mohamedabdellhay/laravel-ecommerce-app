<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->decimal('price', 8, 2);
            $table->decimal('sale_price', 8, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
