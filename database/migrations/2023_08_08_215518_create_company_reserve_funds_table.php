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
        Schema::create('company_reserve_funds', function (Blueprint $table) {
            $table->id();
            $table->decimal('royality_fund', 18, 8)->default(0);
            $table->decimal('club_income', 18, 8)->default(0);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_reserve_funds');
    }
};
