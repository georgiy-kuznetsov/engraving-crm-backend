<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('status_id')
                    ->nullable()
                    ->after('number')
                    ->references('id')
                    ->on('order_statuses')
                    ->nullOnDelete();

            $table->foreignId('coupon_id')
                    ->nullable()
                    ->after('price_amount')
                    ->constrained()
                    ->nullOnDelete();

            $table->foreignId('shipping_method_id')
                    ->nullable()
                    ->after('discount_amount')
                    ->constrained()
                    ->nullOnDelete();

            $table->foreignId('payment_method_id')
                    ->nullable()
                    ->after('total_amount')
                    ->constrained()
                    ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
            $table->dropForeign(['status_id']);
            $table->dropForeign(['shipping_method_id']);
            $table->dropForeign(['payment_method_id']);
            
            $table->dropColumn([
                'coupon_id',
                'status_id',
                'shipping_method_id',
                'payment_method_id',
            ]);
        });
    }
};
