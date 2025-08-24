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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('number')->unique()->comment('Visible table number');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('qr_link')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->unsignedTinyInteger('capacity')->default(2)->comment('Seating capacity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
