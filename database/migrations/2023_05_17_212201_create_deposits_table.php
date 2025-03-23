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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('agent_id');
            $table->string('method_code');
            $table->decimal('amount', 18,8)->default(0);
            $table->decimal('payable_amount', 18,8)->default(0);
            $table->decimal('charge', 18,8)->default(0);
            $table->decimal('rate', 18,8)->default(0);
            $table->text('detail')->nullable();
            $table->string('method_currency');
            $table->string('payment_s_ac')->nullable();
            $table->string('refer_trx')->nullable();
            $table->string('status');
            $table->string('trx');
            $table->string('admin_feedback');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
