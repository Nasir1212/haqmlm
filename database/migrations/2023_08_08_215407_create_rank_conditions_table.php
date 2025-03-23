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
        Schema::create('rank_conditions', function (Blueprint $table) {
            $table->id();
            $table->integer('position')->default(0); 
            $table->integer('left')->default(0);
            $table->integer('right')->default(0);
            $table->string('rank_name',10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rank_conditions');
    }
};
