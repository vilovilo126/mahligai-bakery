<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('id')
                ->constrained('customers')->nullOnDelete();
            $table->unsignedInteger('queue_number')->nullable()->after('customer_id')->unique();
            $table->date('pickup_date')->nullable()->after('payment_status');
            $table->time('pickup_time')->nullable()->after('pickup_date');
            $table->text('bakery_request')->nullable()->after('pickup_time');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn(['customer_id', 'queue_number', 'pickup_date', 'pickup_time', 'bakery_request']);
        });
    }
};
