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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('table_id')->nullable();
            $table->enum('order_type', ['dine-in', 'takeaway']);

            $table->string('customer_phone', 15)->nullable();
            $table->enum('status', ['pending', 'preparing', 'ready', 'served', 'cancelled'])->default('pending');

            $table->decimal('subtotal', 10, 2);
            $table->decimal('gst', 8, 2);
            $table->timestamp('order_date');
            $table->timestamp('ready_time')->nullable();
            $table->text('notes')->nullable();

            $table->enum('payment_mode', ['cash', 'upi', 'card', 'online'])->default('cash');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');

            $table->string('transaction_id')->nullable();
            $table->timestamp('payment_date')->nullable();

            $table->foreign('table_id')->references('id')->on('tables');

            $table->index(['status', 'order_date']);
            $table->index('table_id');
            $table->index(['payment_status', 'payment_mode']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
