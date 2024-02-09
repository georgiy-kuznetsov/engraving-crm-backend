<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_billet', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->double('price', 8, 2)->unsigned();
            $table->string('photo')->nullable();
            $table->integer('quantity')->unsigned();
            $table->double('amount', 8, 2)->unsigned();

            $table->foreignId('order_id')
                    ->constrained()
                    ->cascadeOnDelete();
            $table->foreignId('billet_id')
                    ->constrained()
                    ->cascadeOnDelete();
                    
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_billet');
    }
};
