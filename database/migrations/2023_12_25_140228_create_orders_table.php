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
            $table->string('number')->nullable()->unique();
            $table->decimal('price_amount', 8, 2)->default(0)->unsigned();
            $table->decimal('price_discount', 8, 2)->default(0)->unsigned();
            $table->decimal('discount_amount', 8, 2)->default(0)->unsigned();
            $table->decimal('shipping_amount', 8, 2)->default(0)->unsigned();
            $table->decimal('gratuity_amount', 8, 2)->default(0)->unsigned();
            $table->decimal('total_amount', 8, 2)->default(0)->unsigned();

            $table->foreignId('customer_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
            $table->foreignId('user_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
