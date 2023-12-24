<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_billet_lists', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('billet_id')->references('id')->on('billets');
        });
    }

    public function down(): void
    {
        Schema::table('product_billet_lists', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['billet_id']);
        });
    }
};
