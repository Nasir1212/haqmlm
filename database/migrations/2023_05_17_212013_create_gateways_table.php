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
        Schema::create('gateways', function (Blueprint $table) {
            $table->id();
            $table->integer('withdraw_conversation_rate');
            $table->integer('deposit_conversation_rate');
            $table->string('code');
            $table->string('name');
            $table->string('type')->nullable();
            $table->boolean('sp')->default(false);
           
            $table->longText('image_path')->nullable();
            $table->longText('image_name')->nullable();
            $table->longText('description');
            $table->string('supported_currencies');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateways');
    }
};
