<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_product_lists', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                    ->constrained()
                    ->cascadeOnDelete();
            $table->foreignId('product_id')
                    ->constrained()
                    ->cascadeOnDelete();

            $table->double('price', 8, 2);
            $table->double('discount', 8, 2);
            $table->integer('quantity');
            $table->double('amount');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_product_lists');
    }
};
