<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_billet', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->cascadeOnDelete();
            $table->foreignId('billet_id')->cascadeOnDelete();

            $table->integer('quantity')->default(0)->unsigned();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_billet');
    }
};
