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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category');
            $table->decimal('price', 8, 2); // 8 digits total, 2 after decimal
            $table->string('image')->nullable(); // Path to menu item image
            $table->enum('status', ['available', 'out_of_stock', 'low_stock'])->default('available');
            $table->boolean('is_popular')->default(false);
            $table->unsignedTinyInteger('rating')->default(0); // 0 to 5 stars
            $table->text('ingredients')->nullable(); // Store as JSON or comma-separated
            $table->string('dietary_info')->nullable(); // veg, non-veg, vegan, etc.
            $table->integer('preparation_time')->nullable(); // in minutes
            $table->boolean('is_available')->default(true);
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
