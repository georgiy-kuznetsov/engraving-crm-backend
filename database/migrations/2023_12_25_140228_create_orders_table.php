<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->double('price_amount', 8, 2)->default(0);
            $table->double('discount_amount', 8, 2)->default(0);
            $table->double('shipping_amount', 8, 2)->default(0);
            $table->double('gratuity_amount', 8, 2)->default(0);
            $table->double('total_amount', 8, 2)->default(0);

            $table->foreignId('customer_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
            $table->foreignId('user_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
