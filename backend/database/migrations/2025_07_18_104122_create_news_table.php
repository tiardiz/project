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
        Schema::create('news', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('body');
        $table->string('author')->nullable();
        $table->string('image')->nullable(); // путь к изображению
        $table->unsignedInteger('views')->default(0);
        $table->unsignedInteger('likes')->default(0);
        $table->timestamps(); // created_at и updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
