<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('source_id')
                    ->nullable()
                    ->after('number')
                    ->references('id')
                    ->on('order_sources')
                    ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['source_id']);
            
            $table->dropColumn([
                'source_id',
            ]);
        });
    }
};
