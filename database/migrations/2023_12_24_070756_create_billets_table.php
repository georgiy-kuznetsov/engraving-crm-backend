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
        Schema::create('billets', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255);
            $table->double('price', 8, 2)->default(0);
            $table->text('description')->nullable();
            $table->string('sku', 255)->nullable()->unique();
            $table->string('photo')->nullable();
            $table->integer('stock_quantity')->default(0);

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('provider_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['provider_id']);
        });

        Schema::dropIfExists('billets');
    }
};
