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
        Schema::create('pension_pays', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('gateway_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('account')->nullable();
            $table->string('description')->nullable();
            $table->string('account_qr_code')->nullable();
            $table->decimal('charge', 10, 2)->default(0);
            $table->tinyInteger('status')->default(0); // 0 = pending, 1 = success, 2 = failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pension_pays');
    }
};
