<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->string('surname')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('email', 100)->nullable()->unique();

            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('adress')->nullable();
            $table->string('postcode', 20)->nullable();

            $table->string('website')->nullable()->unique();
            $table->string('telegram')->nullable();
            $table->string('vkontakte')->nullable()->unique();
            $table->string('instagram')->nullable()->unique();
            $table->string('whatsapp')->nullable();

            $table->boolean('is_banned')->default(false);
            $table->boolean('is_regular')->default(false);

            $table->foreignId('user_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
