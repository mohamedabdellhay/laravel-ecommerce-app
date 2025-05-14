<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('filter_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filter_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('filter_translations');
    }
}
