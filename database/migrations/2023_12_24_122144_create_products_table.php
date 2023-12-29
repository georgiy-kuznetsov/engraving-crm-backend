<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('title')->index();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->double('price', 8, 2)->default(0);
            $table->double('sale_price', 8, 2)->nullable();
            $table->string('sku', 255)->nullable()->unique();
            $table->string('photo')->nullable();

            $table->boolean('onsale')->default(false);
            
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('products');
    }
};
