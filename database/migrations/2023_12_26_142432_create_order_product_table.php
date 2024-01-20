<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('photo');
            $table->decimal('price', 8, 2)->unsigned();
            $table->decimal('discount', 8, 2)->unsigned();
            $table->integer('quantity')->unsigned();
            $table->decimal('amount')->unsigned();

            $table->foreignId('order_id')
                    ->constrained()
                    ->cascadeOnDelete();
            $table->foreignId('product_id')
                    ->constrained()
                    ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
