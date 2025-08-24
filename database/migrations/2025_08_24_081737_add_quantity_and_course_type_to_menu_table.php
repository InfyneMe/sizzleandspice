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
        Schema::table('menu', function (Blueprint $table) {
            $table->string('quantity', 10)->default('full')->after('discount_price');
            $table->string('course_type', 20)->default('main_course')->after('quantity');
            $table->index('course_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->dropIndex(['course_type']);
            $table->dropColumn(['quantity', 'course_type']);
        });
    }
};
