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
        // DB::table('tables')->where('status', 'active')->update(['status' => 'available']);
        // DB::table('tables')->where('status', 'inactive')->update(['status' => 'reserved']);
        // Schema::table('tables', function (Blueprint $table) {
        //     $table->enum('status', ['occupied', 'reserved', 'available'])
        //           ->default('available')
        //           ->change();
        // });
        Schema::table('tables', function (Blueprint $table) {
            $table->string('status', 20)->default('available')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // DB::table('tables')->where('status', 'available')->update(['status' => 'active']);
        // DB::table('tables')->where('status', 'reserved')->update(['status' => 'inactive']);
        // Schema::table('tables', function (Blueprint $table) {
        //     $table->enum('status', ['active', 'inactive'])
        //           ->default('active')
        //           ->change();
        // });
        Schema::table('tables', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->change();
        });
    }
};
