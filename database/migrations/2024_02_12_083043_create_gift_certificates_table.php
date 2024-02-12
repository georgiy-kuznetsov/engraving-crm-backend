<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gift_certificates', function (Blueprint $table) {
            $table->id()->from(211);
            $table->string('number')->nullable()->unique();
            $table->double('balance', 8, 2)->default(0.00)->unsigned();
            $table->boolean('is_used_up')->default(false);
            $table->timestamp('expires_at')->index();
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
        Schema::dropIfExists('gift_certificates');
    }
};
