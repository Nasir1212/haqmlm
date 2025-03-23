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
        Schema::create('withdraw_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('withdraw_minimum_limit');
            $table->integer('withdraw_maximum_limit');
            $table->boolean('sun_day')->default(true);
            $table->boolean('mon_day')->default(true);
            $table->boolean('tue_day')->default(true);
            $table->boolean('wed_day')->default(true);
            $table->boolean('thu_day')->default(true);
            $table->boolean('fri_day')->default(true);
            $table->boolean('sat_day')->default(true);
            $table->boolean('withdraw_switch')->default(true);
            $table->string('message')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_settings');
    }
};
