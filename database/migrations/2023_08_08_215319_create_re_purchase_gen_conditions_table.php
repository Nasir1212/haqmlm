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
        Schema::create('re_purchase_gen_conditions', function (Blueprint $table) {
            $table->id();
          
            $table->integer('position')->default(0); 
            $table->string('level')->nullable();
            $table->decimal('amount',18,2)->nullable()->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('re_purchase_gen_conditions');
    }
};
