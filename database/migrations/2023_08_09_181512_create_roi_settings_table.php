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
        Schema::create('roi_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('roi_send_amount',18,2)->default(0.2);
            $table->integer('roi_send_date_day');
            $table->integer('roi_send_stop');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roi_settings');
    }
};
