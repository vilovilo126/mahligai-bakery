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

            $table->string('customer_name');
            $table->string('customer_phone');

            $table->string('payment_method')->default('qris');
            $table->string('order_status')->default('menunggu_pembayaran');
            $table->string('payment_status')->default('belum_bayar');

            $table->unsignedInteger('subtotal')->default(0);
            $table->unsignedInteger('add_ons_total')->default(0);
            $table->unsignedInteger('qris_fee')->default(0);
            $table->unsignedInteger('total')->default(0);

            $table->json('order_data');

            $table->timestamps();

            $table->index('payment_method');
            $table->index('order_status');
            $table->index('payment_status');
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
