<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_attribute', function (Blueprint $table) {
            $table->id();

            $table->foreignId('attribute_id')
                    ->references('id')
                    ->on('attributes')
                    ->onDelete('cascade');

            $table->foreignId('product_id')
                    ->onDelete('cascade')
                    ->constrained();

            $table->float('value')->unsigned();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attribute');
    }
};
