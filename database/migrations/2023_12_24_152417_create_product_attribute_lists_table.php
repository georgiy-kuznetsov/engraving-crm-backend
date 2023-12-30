<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_attribute_lists', function (Blueprint $table) {
            $table->id();

            $table->foreignId('attribute_id')
                    ->references('id')
                    ->on('product_attributes')
                    ->cascadeOnDelete();

            $table->foreignId('product_id')
                    ->constrained()
                    ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_attribute_lists');
    }
};
