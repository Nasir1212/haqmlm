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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trx')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('trx_type')->nullable();
            $table->decimal('amount',18,8)->default(0);
            $table->decimal('post_balance',18,8)->default(0);
            $table->string('details',300)->nullable();
            $table->string('remark',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
