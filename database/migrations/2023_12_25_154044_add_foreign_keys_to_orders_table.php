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
                    ->after('number')
                    ->references('id')
                    ->on('order_statuses');

            $table->foreignId('coupon_id')
                    ->after('price_amount')
                    ->constrained();

            $table->foreignId('shipping_method_id')
                    ->after('discount_amount')
                    ->constrained();

            $table->foreignId('payment_method_id')
                    ->after('total_amount')
                    ->constrained();
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
