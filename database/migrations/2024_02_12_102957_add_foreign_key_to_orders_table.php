<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('gift_certificate_id')
                    ->nullable()
                    ->after('coupon_id')
                    ->references('id')
                    ->on('gift_certificates')
                    ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['gift_certificate_id']);
            
            $table->dropColumn([
                'gift_certificate_id',
            ]);
        });
    }
};
