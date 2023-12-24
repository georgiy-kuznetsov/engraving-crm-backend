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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('phone', 50)->unique()->nullable();
            $table->string('email', 100)->unique()->nullable();

            $table->string('country', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('adress', 100)->nullable();
            $table->string('postcode', 20)->nullable();

            $table->string('store_link', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('telegram')->nullable();
            $table->string('vkontakte')->nullable();
            $table->string('instagram')->nullable();

            $table->foreignId('user_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::dropIfExists('providers');
    }
};
