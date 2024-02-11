<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('payment_status_id')
                    ->nullable()
                    ->after('status_id')
                    ->references('id')
                    ->on('order_payment_statuses')
                    ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['payment_status_id']);
            
            $table->dropColumn([
                'payment_status_id',
            ]);
        });
    }
};
