<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->emum('type', ['image', 'link']);
            $table->foreignId('order_id')
                    ->constrained()
                    ->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_receipts');
    }
};
