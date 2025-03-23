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
        Schema::create('user_extras', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('paid_left')->nullable()->default(0);
            $table->integer('paid_right')->nullable()->default(0);
            $table->integer('left_free')->nullable()->default(0);
            $table->integer('right_free')->nullable()->default(0);
            $table->integer('lltp')->nullable()->default(0);
            $table->integer('lrtp')->nullable()->default(0);
            $table->integer('ltp')->nullable()->default(0);
            $table->integer('rtp')->nullable()->default(0);
            $table->integer('clp')->nullable()->default(0);
            $table->integer('crp')->nullable()->default(0);
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_extras');
    }
};
