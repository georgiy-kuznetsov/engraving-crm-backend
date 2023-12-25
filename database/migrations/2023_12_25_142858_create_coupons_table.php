<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('promocode')->unique();
            $table->timestamp('term')->index();
            $table->double('discount_size')->default(0);
            $table->enum('unit', ['percent', 'currency'])->default('currency');

            $table->foreignId('user_id')->constrained();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
