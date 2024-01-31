<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->from(3001);

            $table->string('login')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('avatar_large')->nullable();
            $table->string('avatar_small')->nullable();

            $table->boolean('active')->default(false);
            $table->boolean('is_owner')->default(false);

            $table->rememberToken();
            $table->timestamps();

            $table->softDeletes();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
