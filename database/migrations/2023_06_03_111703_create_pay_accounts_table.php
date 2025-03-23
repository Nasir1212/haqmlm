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
        Schema::create('pay_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('gateway_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->longText('account')->nullable();
            $table->longText('description')->nullable();
            $table->longText('account_qr_code')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_accounts');
    }
};
