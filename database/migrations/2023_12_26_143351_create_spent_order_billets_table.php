<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spent_order_billets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained();
            $table->foreignId('billet_id')->constrained();
            $table->integer('quantity');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spent_order_billets');
    }
};
